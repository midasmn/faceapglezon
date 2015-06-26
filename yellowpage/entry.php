<?php
require_once('lib/OpenGraph.php');

$graph = OpenGraph::fetch('http://www.rottentomatoes.com/m/10011268-oceans/');
var_dump($graph->keys());
var_dump($graph->schema);

foreach ($graph as $key => $value) {
    echo "$key => $value";
}