<?php

if($argc > 1){
    array_shift($argv);
    foreach($argv as $model){
        $paramName = strtolower($model);
        file_put_contents(__DIR__ . "/src/Adapter/{$model}Adapter.php", <<<EOT
<?php

namespace CampusAppointment\\Adapter;

use CampusAppointment\\Model\\{$model};

interface {$model}Adapter
{
    public function persist({$model} \$$paramName);
    public function persistBatch(array \${$paramName}s);
    public function factory(\$data): {$model};
    public function factoryBatch(array \$data): array;
}
EOT
);
    }
}else{
    exit("Usage: {$argv[0]} ModelA ModelB ... ModelN\n");
}