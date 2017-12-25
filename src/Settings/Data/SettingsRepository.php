<?php

namespace Lychee\Settings\Data;

use Lychee\Support\Data\RepositoryInterface;
use Doctrine\DBAL\Connection;

class SettingsRepository implements RepositoryInterface
{
    protected $db;
    protected $hidden = [
        'username' => 'username',
        'password' => 'password',
        'identifier' => 'identifier'
    ];
    protected $table = 'lychee_settings';
    protected $tableAlias = 's';

    public function __construct(Connection $db)
    {
        $this->db = $db;
    }
    
    public function find()
    {
        $qb = $this->db->createQueryBuilder();

        $qb->select('*')
            ->from($this->table, $this->tableAlias)
            ->where(
                $qb->expr()->notIn(
                    $this->tableAlias.'.key',
                    $qb->createNamedParameter($this->hidden, Connection::PARAM_STR_ARRAY)
                )
            );

        return (
            (new SettingsHydrator(
                $qb->execute()->fetchAll()
            ))->hydrate()
        );
    }

    public function save($entity): void
    {

    }
}
