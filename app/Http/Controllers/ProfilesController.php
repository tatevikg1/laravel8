<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;
use Laravel\Jetstream\Jetstream;

class ProfilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * All users(id, name, email, profile photo) or filtered by name.
     * */ 
    public function index(Request $request)
    {    
        return Inertia::render('Profile/Index', [
            'user'  => Auth::user('id', 'name', 'email', 'profile_photo_path'), 
            'parameter'  => $request->term,
            'users' => User::where( 'id', '!=', auth()->id() )
                ->when($request->term, function($query, $term){
                    $query->where('name', 'LIKE', '%' . $term . '%');
                })
                ->select('id', 'name', 'email', 'profile_photo_path')
                ->paginate(3)
        ]);
    }

    public function show($userId)
    {
        $profile = User::query()
            ->select('id', 'name', 'email', 'profile_photo_path')
            ->where('id', $userId)
            ->firstOrFail();
        
        $authUser = Auth::user('id', 'name', 'email', 'profile_photo_path');

        if($profile->id == $authUser->id){
            return Inertia::render('Profile/Show', [
                'user'  => $authUser, 
                'profile' => $profile,
                'images' => Image::where('user_id', $profile->id)->get(),
            ]);
        }

        return Inertia::render('Profile/Show', [
            'user'  => $authUser, 
            'profile' => $profile,
            'images' => Image::where([['user_id', $profile->id], ['public', true]])->get(),
        ]);
    }

    /**
     * Show the general profile settings screen.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Inertia\Response
     */
    public function edit(Request $request)
    {
        return Jetstream::inertia()->render($request, 'Profile/Edit', [
            'sessions' => $this->sessions($request)->all(),
        ]);
    }

    /**
     * Get the current sessions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Support\Collection
     */
    public function sessions(Request $request)
    {
        if (config('session.driver') !== 'database') {
            return collect();
        }

        return collect(
            DB::connection(config('session.connection'))->table(config('session.table', 'sessions'))
                    ->where('user_id', $request->user()->getAuthIdentifier())
                    ->orderBy('last_activity', 'desc')
                    ->get()
        )->map(function ($session) use ($request) {
            $agent = $this->createAgent($session);

            return (object) [
                'agent' => [
                    'is_desktop' => $agent->isDesktop(),
                    'platform' => $agent->platform(),
                    'browser' => $agent->browser(),
                ],
                'ip_address' => $session->ip_address,
                'is_current_device' => $session->id === $request->session()->getId(),
                'last_active' => Carbon::createFromTimestamp($session->last_activity)->diffForHumans(),
            ];
        });
    }

    /**
     * Create a new agent instance from the given session.
     *
     * @param  mixed  $session
     * @return \Jenssegers\Agent\Agent
     */
    protected function createAgent($session)
    {
        return tap(new Agent, function ($agent) use ($session) {
            $agent->setUserAgent($session->user_agent);
        });
    }


}
