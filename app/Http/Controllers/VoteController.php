<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\VoteSet;

class VoteController extends Controller
{
    const TITLE = '投票';

    /**
     * List all vote sets.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $voteSets = VoteSet::orderBy('id', 'desc')->get();
        return view('vote.index', [
            'title' => self::TITLE,
            'voteSets' => $voteSets,
        ]);
    }

    /**
     * Create new vote set.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('vote.create', [
            'title' => self::TITLE,
        ]);
    }

    /**
     * Store the new vote set.
     *
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'anonymous' => 'required',
            'item_count' => 'required|numeric|gte:0',
            'item_options' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        DB::transaction(function () use ($request) {
            $voteSet = VoteSet::create([
                'name' => $request->get('name'),
                'status' => 'prep',  // 'prep', 'open', 'close'
                'anonymous' => $request->get('anonymous') == '1',
            ]);
            $options = $request->get('item_options') == '0' ? "賛成\n反対\n保留" : "信任\n不信任";
            for ($i = 0; $i < intval($request->get('item_count')); ++$i) {
                $voteSet->items()->create([
                    'seq' => $i,
                    'name' => '項目'.($i + 1),
                    'options' => $options,
                ]);
            }
        });
        return redirect()->route('votes.index');
    }

    /**
     * Edit the vote set or vote.
     *
     * @param  App\Models\VoteSet  $voteSet
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(VoteSet $voteSet, Request $request)
    {
        if ($voteSet->status == 'open') {
            if ($voteSet->histories()->where('user_id', $request->get('account')['id'])->count()) {
                if (in_array('voteadmin', $request->get('account')['privs'], true)) {
                    return $this->editVoteSet($voteSet, $request);
                } else {
                    return redirect()->route('votes.index');
                }
            } else {
                return $this->vote($voteSet, $request);
            }
        } else if ($voteSet->status == 'prep') {
            return $this->editVoteSet($voteSet, $request);
        } else {
            return redirect()->route('votes.index');
        }
    }

    /**
     * Edit the vote set.
     *
     * @param  App\Models\VoteSet  $voteSet
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function editVoteSet(VoteSet $voteSet, Request $request)
    {
        return view('vote.edit', [
            'title' => self::TITLE,
            'voteSet' => $voteSet,
        ]);
    }

    /**
     * Vote.
     *
     * @param  App\Models\VoteSet  $voteSet
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function vote(VoteSet $voteSet, Request $request)
    {
        return view('vote.vote', [
            'title' => self::TITLE,
            'voteSet' => $voteSet,
        ]);
    }

    /**
     * Update the vote set or Store the vote.
     *
     * @param  App\Models\VoteSet  $voteSet
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function update(VoteSet $voteSet, Request $request)
    {
        if ($voteSet->status == 'open') {
            if ($voteSet->histories()->where('user_id', $request->get('account')['id'])->count()) {
                if (in_array('voteadmin', $request->get('account')['privs'], true)) {
                    return $this->updateVoteSetStatus($voteSet, $request);
                } else {
                    return redirect()->route('votes.index');
                }
            } else {
                return $this->storeVote($voteSet, $request);
            }
        } else if ($voteSet->status == 'prep') {
            return $this->updateVoteSet($voteSet, $request);
        } else {
            return redirect()->route('votes.index');
        }
    }

    /**
     * Update the vote set.
     *
     * @param  App\Models\VoteSet  $voteSet
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function updateVoteSet(VoteSet $voteSet, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
            'name' => 'required',
            'anonymous' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        DB::transaction(function () use ($voteSet, $request) {
            $voteSet->status = $request->get('status');
            $voteSet->name = $request->get('name');
            $voteSet->anonymous = $request->get('anonymous') == '1';
            $voteSet->save();
            $voteSet->items()->delete();
            $seq = 0;
            $nameList = $request->get('item_name');
            $optionList = $request->get('item_options');
            for ($i = 0; $i < count($nameList); ++$i) {
                if (trim($nameList[$i]) && trim($optionList[$i])) {
                    $voteSet->items()->create([
                        'seq' => $seq,
                        'name' => $nameList[$i],
                        'options' => $optionList[$i],
                    ]);
                    ++$seq;
                }
            }
        });
        return redirect()->route('votes.index');
    }

    /**
     * Update the status of the vote set.
     *
     * @param  App\Models\VoteSet  $voteSet
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function updateVoteSetStatus(VoteSet $voteSet, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $voteSet->status = $request->get('status');
        $voteSet->save();
        return redirect()->route('votes.index');
    }

    /**
     * Store the vote.
     *
     * @param  App\Models\VoteSet  $voteSet
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function storeVote(VoteSet $voteSet, Request $request)
    {
        DB::transaction(function () use ($voteSet, $request) {
            $voteSet->histories()->create([
                'user_id' => $request->get('account')['id'],
                'user_name' => $request->get('account')['name'],
            ]);
            $user = $request->get('account')['id'];
            $voter = $voteSet->anonymous ? md5($user . (new DateTime())->format(DateTime::ATOM)) : $user;
            foreach ($voteSet->items()->get() as $item) {
                $item->votes()->create([
                    'voter' => $voter,
                    'vote' => $request->get('item_'.$item->id),
                ]);
            }
        });
        return redirect()->route('votes.index');
    }

    /**
     * Show the result of the vote set.
     *
     * @param  App\Models\VoteSet  $voteSet
     * @param  Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function show(VoteSet $voteSet, Request $request)
    {
        return view('vote.show', [
            'title' => self::TITLE,
            'voteSet' => $voteSet,
        ]);
    }
}
