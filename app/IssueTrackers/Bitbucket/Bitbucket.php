<?php

namespace App\IssueTrackers\Bitbucket;

// https://gentlero.bitbucket.io/bitbucket-api/1.0/examples/repositories/issues.html
use App\IssueTrackers\IssueTrackerException;
use Bitbucket\API\Authentication\Basic;
use Bitbucket\API\Groups;
use Bitbucket\API\Http\Listener\OAuth2Listener;
use Bitbucket\API\Repositories\Hooks;
use Bitbucket\API\Repositories\Issues;
use Bitbucket\API\Repositories\PullRequests;

class Bitbucket
{
    protected $auth;
    protected static $oauthParameters;

    public static function setOAuth($parameters)
    {
        static::$oauthParameters = $parameters;
    }

    public function __construct()
    {
        $this->auth = new Basic(config('services.bitbucket.user'), config('services.bitbucket.password'));
    }

    public function getIssues($account, $repoSlug, $options = [])
    {
        $issue = new Issues();
        $this->setAuth($issue);

        return $this->parseResponse(
            $issue->all($account, $repoSlug, $options)
        );
    }

    public function getIssue($account, $repoSlug, $id)
    {
        $issue = new Issues();
        $this->setAuth($issue);
        return $this->parseResponse(
            $issue->get($account, $repoSlug, $id)
        );
    }

    public function updateIssue($account, $repoSlug, $id, $fields)
    {
        $issue = new Issues();
        $this->setAuth($issue);
        return $this->parseResponse(
            $issue->update($account, $repoSlug, $id, $fields)
        );
    }

    public function createIssue($account, $repoSlug, $title, $content = '', $extra = [])
    {
        $issue = new Issues();
        $this->setAuth($issue);
        return $this->parseResponse(
            $issue->create($account, $repoSlug, array_merge([
                'title'     => $title,
                'content'   => ["raw" => $content],
                'kind'      => 'task',
                'priority'  => 'major',
                'status'    => 'new'
            ], $extra))
        );
    }

    public function getIssueComments($account, $repoSlug, $id)
    {
        $issue = new Issues();
        $this->setAuth($issue);
        return $this->parseResponse(
            $issue->comments()->all($account, $repoSlug, $id)
        );
    }

    public function createComment($account, $repoSlug, $id, $comment)
    {
        $issue = new Issues();
        $this->setAuth($issue);
        return $this->parseResponse(
            $issue->comments()->create($account, $repoSlug, $id,  ["raw" => $comment] )
        );
    }

    public function parseResponse($response)
    {
        $response = json_decode($response->getContent());
        //dd($response);
        if (isset($response->type) && $response->type == 'error'){
           throw new IssueTrackerException($response->error->message . ':' . collect($response->error->fields)->map(function($value, $key){
                return $key . " => " . $value;
           })->implode("\n"));
        }
        return $response;
    }

    public function getWebhooks($account, $repoSlug)
    {
        $hooks  = new Hooks();
        $this->setAuth($hooks);

        return $this->parseResponse(
            $hooks->all($account, $repoSlug)
        );
    }

    public function createHook($account, $repoSlug, $url)
    {
        $hook  = new Hooks();
        $this->setAuth($hook);

        $response = $hook->create($account, $repoSlug, [
            'description' => 'Bucketdesk',
            'url'         => $url,
            'active'      => true,
            'events'      => [
                'issue:created',
                'issue:updated'
            ]
        ]);
        return $this->parseResponse($response);
    }

    public function getGroups($account)
    {
        $groups = new Groups();
        $this->setAuth($groups);

        return $this->parseResponse(
            $groups->get($account)
        );
    }

    public function createPullRequest($account, $repoSlug, $title, $fromBranch, $toBranch)
    {
        $pr = new PullRequests();
        $this->setAuth($pr);
        return $this->parseResponse(
            $pr->create($account, $repoSlug, [
                "title" => $title,
                "description" => $title,
                "state" => "OPEN",
                "open" =>  true,
                "closed" => false,
                "fromRef" => [
                    "id" => "refs/heads/$fromBranch",
                    "repository" => [
                        "slug" => "$account/$repoSlug",
                    ]
                ],
                "toRef" => [
                    "id" => "refs/heads/$toBranch",
                    "repository" => [
                        "slug" => "$account/$repoSlug",
                    ]
                ],
                "locked" => false,
            ])
        );
    }

    private function setAuth($class)
    {
        //$issue->setCredentials($this->auth);
        $class->getClient()->setApiVersion('2.0')->addListener(
            new OAuth2Listener(static::$oauthParameters ?? [
                'client_id'         => config('services.bitbucket.oauth.key'),
                'client_secret'     => config('services.bitbucket.oauth.secret'),
            ])
        );
    }
}
