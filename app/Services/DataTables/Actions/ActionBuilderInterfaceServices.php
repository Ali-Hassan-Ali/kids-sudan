<?php

namespace App\Services\DataTables\Actions;

Interface ActionBuilderInterfaceServices
{
    public function buttons(array $buttons): self;
    
    public function bassRoute(string $bassRoute): self;

    public function excepteButtons(array $excepted): self;

    public function build();
    
}//end of clas