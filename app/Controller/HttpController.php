<?php

declare(strict_types=1);

namespace App\Controller;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

#[Controller]
class HttpController extends AbstractController
{
    #[RequestMapping('get_request')]
    public function get_request()
    {
        $file_info = [];
        /** @var \Hyperf\HttpMessage\Upload\UploadedFile[] $files */
        $files = $this->request->getUploadedFiles();
        foreach ($files as $key => $file) {
            $file_name = $file->getClientFilename();
            file_put_contents(__DIR__ . '/../../storage/http_get_request/files/' . $file_name, $file);
            $file_info[] = [
                'key' => $key,
                'file' => $file_name,
            ];
        }

        $result = [
            'request' => $this->request->all(),
            'file_info' => $file_info,
        ];

        $json = json_encode($result, JSON_UNESCAPED_UNICODE);

        file_put_contents(__DIR__ . '/../../storage/http_get_request/logs/' . date('YmdHis') . '.json', $json);

        return $json;
    }

}