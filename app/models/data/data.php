<?php


function getSampleData() {
    return json_decode((file_get_contents(__DIR__.'/sampleData.json')), true);
}




