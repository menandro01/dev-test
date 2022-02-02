<?php
namespace Razoyo\AnimalProfile\Animal;


class Anteater implements \Razoyo\AnimalProfile\Animal\AnimalInterface
{
    public function getContent()
    {
        return 'data:image/jpeg;base64,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';
    }
}