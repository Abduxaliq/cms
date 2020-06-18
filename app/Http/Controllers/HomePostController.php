<?php

namespace App\Http\Controllers;

use App\ModelAnswers;
use App\ModelPosts;
use App\ModelQuestions;
use App\ModelVotingHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mockery\Exception;

class HomePostController extends HomeController
{
    public function post_search(Request $request)
    {
        if ($request->has('search') && !empty($request->search) && !self::$isMobile) {
            $searchOrg = $request->input('search');
            $search = str_replace(' ', '%', $searchOrg);

            $categoryPostsList = ModelPosts::whereDate('date', '<=', Carbon::now()->toDateTimeString())
                ->where('active', 1)
                ->orderBy('date', 'DESC')
                ->where(function ($query) use ($search) {
                    $query->where('short_title', 'LIKE', "%$search%")
                        ->orWhere('title', 'LIKE', "%$search%")
                        ->orWhere('content', 'LIKE', "%$search%")
                        ->orWhere('description', 'LIKE', "%$search%")
                        ->orWhere('slug', 'LIKE', "%$search%");
                })->limit(100)->get();

            $categoryData = (object)['name' => $searchOrg];

            $postsList = $this->centerPosts;
            $rightPostsList = [
                isset($postsList[20]) ? $postsList[20] : [],
                isset($postsList[23]) ? $postsList[23] : [],
                isset($postsList[24]) ? $postsList[24] : [],
                isset($postsList[26]) ? $postsList[26] : [],
                isset($postsList[25]) ? $postsList[25] : []
            ];

            return view(self::$prefix . '.category_list', compact(
                'rightPostsList', 'categoryPostsList', 'categoryData'
            ));
        } else {
            return redirect('/');
        }
    }

    public function post_voting(Request $request)
    {
        // dd([$request->ip(), $request->getClientIp(), $request->getClientIps()]);
        $id = (int)$request->answer;
        $ip = $request->ip();
        if ($id > 0) {
            $voteCount = ModelAnswers::where('id', $id)->first();

            if ($voteCount == null) {
                return redirect('/voting');
            }

            try {
                $voteCount = (int)$voteCount->vote_count;
                $voteCount++;

                $votingData = ModelQuestions::where('active', 1)->orderBy('id', 'desc')->first();

                $firstTime = ModelVotingHistory::where('voting_id', $votingData->id)->where('address', $ip)->first();

                if ($firstTime) {
                    return view('voting_result', compact('votingData'));
                }

                ModelAnswers::where('id', $id)->update([
                    'vote_count' => $voteCount
                ]);

                ModelVotingHistory::create([
                    'voting_id' => $votingData->id,
                    'address' => $ip
                ]);

                return redirect('/voting');
            } catch (Exception $e) {
                return redirect('/voting');
            }
        } else {
            return redirect('/voting');
        }
    }
}
