<?php

describe('home page', function () {
    test('shows the title and has no js errors', function () {
        $page = visit(route('home'));

        $page->assertSee('Dev Pups')
            ->assertNoJavascriptErrors();
    });
});
