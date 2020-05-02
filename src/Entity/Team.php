<?php

namespace App\Entity;

class Team
{
    private string $name;
    private string $country;
    private string $logo;
    /**
     * @var Player[]
     */
    private array $players;
    private string $coach;
    private int $goals;
    private int $sum;


    public function __construct(string $name, string $country, string $logo, array $players, string $coach)
    {
        $this->assertCorrectPlayers($players);

        $this->name = $name;
        $this->country = $country;
        $this->logo = $logo;
        $this->players = $players;
        $this->coach = $coach;
        $this->goals = 0;
       
    }

    public function getPostime(): array
    {   
        $goalkeeper = 0;
        $attacker = 0;
        $back = 0;
        $halfback = 0;

        foreach ($this->players as $player) {
            if ($player->getPosition() == 'В') {
                $goalkeeper += $player->getPlayTime();
            }
            if ($player->getPosition() == 'Н') {
                $attacker += $player->getPlayTime();
            }
            if ($player->getPosition() == 'З') {
                $back += $player->getPlayTime();
            }
            if ($player->getPosition() == 'П') {
                $halfback += $player->getPlayTime();
            }
           
        }
            return array($goalkeeper, $attacker, $back, $halfback);

    }

    public function getSum(): int
    {   
        $sum = 0;

        foreach ($this->players as $player) {

           $sum += $player->getPlayTime();
        }
        return $sum;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    /**
     * @return Player[]
     */
    public function getPlayersOnField(): array
    {
        return array_filter($this->players, function (Player $player) {
            return $player->isPlay();
        });
    }

    public function getPlayers(): array
    {
        return $this->players;
    }

    public function getPlayer(int $number): Player
    {
        foreach ($this->players as $player) {
            if ($player->getNumber() === $number) {
                return $player;
            }
        }

        throw new \Exception(
            sprintf(
                'Player with number "%d" not play in team "%s".',
                $number,
                $this->name
            )
        );
    }

    public function getCoach(): string
    {
        return $this->coach;
    }

    public function addGoal(): void
    {
        $this->goals += 1;
    }

    public function getGoals(): int
    {
        return $this->goals;
    }


    private function assertCorrectPlayers(array $players)
    {
        foreach ($players as $player) {
            if (!($player instanceof Player)) {
                throw new \Exception(
                    sprintf(
                        'Player should be instance of "%s". "%s" given.',
                        Player::class,
                        get_class($player)
                    )
                );
            }
        }
    }
}