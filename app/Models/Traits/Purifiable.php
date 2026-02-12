<?php

namespace App\Models\Traits;

use App\Models\Setting;

trait Purifiable
{
    /**
     * Updates the content and html attribute of the given model.
     *
     * @param string $rawHtml
     *
     * @return \Illuminate\Database\Eloquent\Model $this
     */
    public function setPurifiedContent($rawHtml)
    {
        $this->content = clean($rawHtml, ['HTML.Allowed' => '']);
        $this->html = clean($rawHtml, Setting::grab('purifier_config'));

        return $this;
    }
}
