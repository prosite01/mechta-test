<?php

namespace Search;

interface SearchInterface
{
    public static function doSearch(): void;

    public static function renderSearchResults(array $result): void;

    public static function renderSearchForm(): void;
}