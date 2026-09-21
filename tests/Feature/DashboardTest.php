<?php

test('visitors can access the speed test home page', function () {
    $response = $this->get(route('home'));

    $response->assertOk();
});
