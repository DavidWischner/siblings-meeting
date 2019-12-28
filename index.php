<?php
$config = [
    'date' => 'jan1',
    'food' => 'piz',
    'game' => 'andor',
    'location' => 'neur',
    'additional_participants' => ['Nina', 'Matthias'],
];

class AbstractSelector {
    /** @var string[] */
    protected $options;
    
    public function getOption(string $identifier): string
    {
        if (!isset($this->options[$identifier])) {
            return $identifier;
        }
        return $this->options[$identifier];
    }
    
    public function getRandomOption(): string
    {
        return $this->options[array_rand($this->options)];
    }
}

class GameSelector extends AbstractSelector {
    protected $options = [
        'exit' => 'Exit-Game/Escape Room', 
        'scy' => 'Scythe', 
        'pue' => 'Puerto Rico', 
        'ist' => 'Istanbul', 
        'stone' => 'Stone Age', 
        'catan' => 'Die Siedler von Catan', 
        'magic' => 'Magic the Gathering',
        'domin' => 'Dominion',
        'crew' => 'Die Crew',
        'wing' => 'Flügelschlag',
        'andor' => 'Die Legenden von Andor',
    ];
}
class DateSelector extends AbstractSelector {
    protected $options = [
        'jan1' => '2020-01-11',
        'jan2' => '2020-01-18',
        'jan3' => '2020-01-25',
        'feb1' => '2020-02-01',
        'feb2' => '2020-02-08',
        'feb3' => '2020-02-22',
        'feb4' => '2020-02-29',
        'mar1' => '2020-03-07',
        'mar2' => '2020-03-14',
        'mar3' => '2020-03-21',
        'mar4' => '2020-03-28',
    ];
}
class FoodSelector extends AbstractSelector {
    protected $options = [
        'piz' => 'Pizza',
        'rac' => 'Raclette',
        'bur' => 'Burger (mit Davids Original Reispaddies) und Pommes',
    ];
}
class LocationSelector extends AbstractSelector {
    protected $options = [
        'rodd' => 'Roddahn',
        'neur' => 'Neuroddahn',
        'berl' => 'Berlin',
    ];
}
class Parents {
    private $children;
    private $childrenOptions = [
        'andreas-hedi' => ['Johanna', 'David', 'Jakob'],
        'roxanne-yves' => ['Paul', 'Chris'],
        'alice-bob' => ['Eve', 'Eva', 'Evelyn'],
    ];
    
    public function __construct(array $parentNames) {
        $configKeys = $this->generateConfigKeys($parentNames);
        foreach ($configKeys as $configKey) {
            if (isset($this->childrenOptions[$configKey])) {
                $this->children = $this->childrenOptions[$configKey];
                break;
            }
        }
    }

    public function generateConfigKeys(array $parentNames) {
        if (!isset($parentNames[0]) || !isset($parentNames[1])) {
            throw new InvalidArgumentException('Invalid ParentNames given - expected array with two elements');
        }
        
        return [
            strtolower($parentNames[0]) . '-' . strtolower($parentNames[1]), 
            strtolower($parentNames[1]) . '-' . strtolower($parentNames[0]),
        ];
    }

    public function getChildren() {
        return $this->children;
    }
}

$gameSelector = new GameSelector();
if (empty($config['game']) || !($gameOption = $gameSelector->getOption($config['game']))) {
    $gameOption = $gameSelector->getOption('exit');
}

$parents = new Parents(['Hedi', 'Andreas']);
$participants = $parents->getChildren();
if (!empty($config['additional_participants'])) {
    $participants = array_merge($participants, $config['additional_participants']);
}

$dateSelector = new DateSelector();
if (empty($config['date']) || !$dateOption = $dateSelector->getOption($config['date'])) {
    $dateOption = $dateSelector->getRandomOption();
}

$foodSelector = new FoodSelector();
if (empty($config['food']) || !$foodOption = $foodSelector->getOption($config['food'])) {
    $foodOption = $foodSelector->getRandomOption();
}

$locationSelector = new LocationSelector();
if (empty($config['location']) || !$locationOption = $locationSelector->getOption($config['location'])) {
    $locationOption = $locationSelector->getRandomOption();
}

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <div>
            <h1>Siblings meeting</h1>
            <p>
                Hi there, this will be your meeting:
            </p>
            <p>
                Participants: <?=  implode(', ', $participants); ?>
            </p>
            <p>
                Date: <?=  $dateOption ?>
            </p>
            <p>
                Food: <?=  $foodOption ?>
            </p>
            <p>
                Game: <?=  $gameOption ?>
            </p>
            <p>
                Location: <?=  $locationOption ?>
            </p>
        </div>
    </body>
</html>
