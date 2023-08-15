<?php
/*
 * Project: sunny-backend
 * File: HasImageTrait.php
 * Author: Islam alalfy
 * Company: alalfy.com
 * Website: https://alalfy.com
 * GitHub: https://github.com/EngALAlfy/sunny-backend
 *
 * Copyright (c) 2023 Islam alalfy. All rights reserved.
 * This code is private and confidential.
 * Unauthorized copying or distribution of this file is strictly prohibited.
 */

namespace App\Traits;

trait HasImageTrait {
    public function getPhotoUrlAttribute(){
        return $this->photo == null ? asset("assets/img/placeholder.jpg") : asset("/storage/photos") . "/" . $this->photo ;
    }

    public function getPhotoNameAttribute(){
        return $this->photo;
    }

    public function getPhotoHtmlAttribute(){
        return <<<End
                  <img width="100" height="100" src="$this->photoUrl" class="img-thumbnail" alt="$this->photoName">
                End;
    }
}
