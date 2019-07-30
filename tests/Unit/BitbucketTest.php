<?php

namespace Tests\Unit;

use App\IssueTrackers\Bitbucket\Bitbucket;
use Tests\TestCase;

/** @group cloud */
class BitbucketTest extends TestCase
{
    /** @test */
    public function can_connect_to_bitbucket()
    {
        $user = new \Bitbucket\API\User();
        $user->getClient()->setApiVersion('2.0')->addListener(
            new \Bitbucket\API\Http\Listener\BasicAuthListener(config('services.bitbucket.user'), config('services.bitbucket.password'))
        );

        // now you can access protected endpoints as $bb_user
        $response = $user->get();
        $this->assertEquals('BadChoice', json_decode($response->getContent())->username);
    }

    /** @test */
    public function it_can_fetch_issues()
    {
        $issues = (new Bitbucket)->getIssues('revo-pos', 'revo-back', [
            'status' => ['open', 'new']
        ]);
        $this->assertTrue(count($issues->values) > 2);
    }

    /** @test */
    public function it_can_create_an_issue()
    {
        $r = (new Bitbucket)->createIssue('revo-pos', 'revo-back', "the title", "The content");
        dd($r);
    }

    /** @test */
    public function can_update_issue(){
        $r = (new Bitbucket)->updateIssue('revo-pos', 'revo-app', 1133, [
              "responsible" =>  'BadChoice',
              "title" => "New Issue 223",
              "status" => "open",
              "priority" => "major",
              "type" => "task",
        ]);
        dd($r);
    }

    /** @test */
    public function it_can_create_a_comment()
    {
        $r = (new Bitbucket)->createComment('revo-pos', 'revo-app', 876, "this is my comment");
        dd($r);
    }

    /** @test */
    public function it_can_update_issue_description()
    {
        $r = (new Bitbucket)->updateIssue('revo-pos', 'revo-app', 876, [
            "content" => ["raw" => 'patata']
        ]);
        dd($r);
    }

    /** @test */
    public function can_fetch_a_single_issue()
    {
        $issue = (new Bitbucket)->updateIssue('revo-pos', 'revo-back', 555, ['status' => 'hola']);
        $this->assertEquals('eduardda', $issue->assignee->nickname);
    }
    
    /** @test */
    public function can_initialize_webhook()
    {
        $hooks = (new Bitbucket)->getWebhooks('revo-pos', 'revo-back');
        $this->assertTrue(count($hooks->values) > 1);
    }

    /** @test */
    public function can_get_groups()
    {
        //$groups = (new Bitbucket)->getGroups('revo-pos');
    }


}
