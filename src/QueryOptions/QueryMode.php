<?php

namespace LuckPermsAPI\QueryOptions;

enum QueryMode: string
{
    case Contextual = 'contextual';
    case NonContextual = 'non_contextual';
}
