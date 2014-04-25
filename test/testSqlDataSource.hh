<?hh

if (is_dir($vendor = getcwd() . '/vendor')) {
    require $vendor . '/autoload.php';
}

if (is_dir($vendor = __DIR__ . '/../vendor')) {
    require($vendor . '/autoload.php');
} elseif (is_dir($vendor = __DIR__ . '/../../..')) {
    require($vendor . '/autoload.php');
} else {
    die(
        'You must set up the project dependencies, run the following commands:' . PHP_EOL .
        'curl -s http://getcomposer.org/installer | php' . PHP_EOL . 
        'php composer.phar install' . PHP_EOL
    );
}

class SomeRecord implements \MusicAnt\Record{

    public function getId() {
        return 1;
    }

    public function getFilterableAttributes() {
        return new Set<string>();
    }

    public function getOrderableAttributes() {
        return new Set<string>();
    }
}
$pdo = new \Pdo('sqlite::memory:', '', '');
$pdo->query('create Table Foo (id int, name char(50))');
$source = new \MusicAnt\DataSource\SqlDataSource<SomeRecord>($pdo , 'Foo');
$source->get(1);
