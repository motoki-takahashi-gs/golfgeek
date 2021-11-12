<?php

require_once __DIR__ . '/../includes/functions.php';

class FileUpload extends Login
{
    protected $user_id;
    protected $fileName;
    private $tmpPath;
    private $imgExtensions;
    private $videoExtensions;
    private $newFileName;

    public function __construct()
    {
        $this->imgExtensions = array('gif', 'png', 'jpg', 'jpeg');
        $this->videoExtensions = array('flv', 'ogg', 'avi', 'mov', 'qt', 'wmv', 'mp4', 'mpg', 'mpeg');

        if ($_FILES['image-video']['name']) {
            $this->fileName = $_FILES['image-video']['name'];
            $this->tmpPath = $_FILES['image-video']['tmp_name'];
        }
    }

    public function getExtension()
    {
        return strtolower(pathinfo($this->fileName, PATHINFO_EXTENSION));
    }

    public function getImgExtensions()
    {
        return $this->imgExtensions;
    }

    public function getVideoExtensions()
    {
        return $this->videoExtensions;
    }

    public function resizeImage($extension)
    {
        // 横幅と高さの最大値を設定
        $width = 1000;
        $height = 1000;

        // オリジナル画像の横幅と高さ
        list($width_orig, $height_orig) = getimagesize($this->tmpPath);

        // オリジナル画像の横縦比
        $ratio_orig = $width_orig / $height_orig;

        if ($width / $height > $ratio_orig) {
            $width = $height * $ratio_orig;
        } else {
            $height = $width / $ratio_orig;
        }

        // オリジナル画像を元に指定サイズで新画像を作成
        $new_image = imagecreatetruecolor($width, $height);
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $orig_image = imagecreatefromjpeg($this->tmpPath);
                break;
            case 'png':
                $orig_image = imagecreatefrompng($this->tmpPath);
                break;
            case 'gif':
                $orig_image = imagecreatefromgif($this->tmpPath);
        }
        imagecopyresampled($new_image, $orig_image, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

        // 作成した新画像を一時パスに保存
        imagejpeg($new_image, $this->tmpPath, 100);

        // 新画像を削除してメモリを解放
        imagedestroy($new_image);
    }

    public function getUsersDirectory()
    {
        // define the directory
        $directory = '../files/' . $this->user_type . '/' . $this->user_id . '/';
        // 作られていなければ各ユーザー専用のフォルダを作成
        if (!is_dir($directory)) mkdir($directory);
        return $directory;
    }

    public function setNewFileName()
    {
        $extension = $this->getExtension() == 'mov' ? 'mp4' : $this->getExtension();
        $this->newFileName = date('YmdHis') . md5(session_id()) . '.' . $extension;
    }

    public function getNewFileName()
    {
        return $this->newFileName;
    }

    public function getFilePath()
    {
        return $this->getUsersDirectory() . $this->getNewFileName();
    }

    public function moveFileFromTmpPath()
    {
        // 一時パスにファイルがアップされているかチェック
        if (is_uploaded_file($this->tmpPath)) {

            // 一時パスから画像へのパスにファイルを移動
            if (move_uploaded_file($this->tmpPath, $this->getFilePath())) {

                // 権限を変更（オーナーは読み書き、グループとその他は読み込みだけ）
                chmod($this->getFilePath(), 0644);
            } else {
                echo 'エラーが発生したため、画像をアップロードできませんでした。';
            }
        }
    }
}
