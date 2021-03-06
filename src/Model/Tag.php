<?php

declare(strict_types=1);

namespace Gitlab\Model;

use Gitlab\Client;

/**
 * @deprecated since version 10.1 and will be removed in 11.0.
 *
 * @property string       $name
 * @property string       $message
 * @property Commit|null  $commit
 * @property Release|null $release
 * @property Project      $project
 * @property bool         $protected
 */
final class Tag extends AbstractModel
{
    /**
     * @var string[]
     */
    protected static $properties = [
        'name',
        'message',
        'commit',
        'release',
        'project',
        'protected',
    ];

    /**
     * @param Client  $client
     * @param Project $project
     * @param array   $data
     *
     * @return Tag
     */
    public static function fromArray(Client $client, Project $project, array $data)
    {
        $branch = new self($project, $data['name'], $client);

        if (isset($data['commit'])) {
            $data['commit'] = Commit::fromArray($client, $project, $data['commit']);
        }

        if (isset($data['release'])) {
            $data['release'] = Release::fromArray($client, $data['release']);
        }

        return $branch->hydrate($data);
    }

    /**
     * @param Project     $project
     * @param string|null $name
     * @param Client|null $client
     *
     * @return void
     */
    public function __construct(Project $project, ?string $name = null, Client $client = null)
    {
        parent::__construct();
        $this->setClient($client);
        $this->setData('project', $project);
        $this->setData('name', $name);
    }
}
