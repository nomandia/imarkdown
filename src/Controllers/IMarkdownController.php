<?php

namespace Nomandia\IMarkdown\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Nomandia\IImage\IImage as Image;

class IMarkdownController extends Controller
{
    protected $fieldName = 'imarkdown_image_file';

    /**
     * @param Request $request
     * @param Image $image
     * @return array|mixed
     */
    public function upload(Request $request, Image $image)
    {
        if ($request->hasFile($this->fieldName)) {
            $validate = $image->validateUpload($request, $this->fieldName);
            if (isset($validate) && !$validate['success']) {
                return $validate;
            }

            return $image->upload($request->file($this->fieldName), [
                'folder' => config('imarkdown.upload_path', '/tmp'),
                'file_prefix' => config('imarkdown.image_prefix', ''),
                'max_width' => config('imarkdown.image_max_width', ''),
            ]);
        }
    }
}