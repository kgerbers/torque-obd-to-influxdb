<?php

namespace Exporters;

use Illuminate\Support\Collection;

interface ExportInterface
{
        public function __construct();

        public function format(string $name, string $time, Collection $data, array $tags);

        public function export(Collection $data);
}