<?php

namespace connect\crm\base\dict;

class Utm extends Dictionary
{
    const SOURCE_GOOGLE = 'google';
    const SOURCE_GA = 'ga';
    const SOURCE_DIRECT = 'direct';
    const SOURCE_YANDEX = 'yandex';
    const SOURCE_YA = 'ya';
    const SOURCE_NONE = Data::EMPTY_NONE;

    const MEDIUM_CPC = 'cpc';
    const MEDIUM_ORGANIC = 'organic';
    const MEDIUM_NOT_SET = Data::EMPTY_NOT_SET;
}
