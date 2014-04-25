<?hh

namespace MusicAnt;

interface Record {

    public function getId(): string;

    public function getFilterableAttributes(): Set<string>;

    public function getOrderableAttributes(): Set<string>;
}
