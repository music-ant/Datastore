<?hh

namespace MusicAnt;

use string;

interface Record {

    public function getId(): string;

    public function getFilterableAttributes(): Set<string>;

    public function getOrderableAttributes(): Set<string>;
}
