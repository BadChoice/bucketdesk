<?php

namespace App\IssueTrackers\Bitbucket;

class FakeBitbucket
{
    public $values = [];

    public function createIssue($account, $repoSlug, $title, $content = '', $extra = [])
    {
        $this->values[] = $title;
        return (object)[
            'id'       => 123,
            'title'    => $title,
            'state'    => $extra['status'] ?? 'new',
            'priority' => $extra['priority'] ?? 'major',
            'kind'     => $extra['kind'] ?? 'bug',
            'assignee' => [
                'nickname' => $extra['responsible'] ?? null
            ]
        ];
    }

    public function updateIssue($account, $repoSlug, $id, $fields)
    {

    }
}
