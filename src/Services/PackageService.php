<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */
namespace App\Services;

class Package {
    public string $name;
    public string $version;
    public string $friendly_name;
    public array $author;
    public string $license;
    public array $files;

    public function __construct($_manifest)
    {
        $manifest = json_decode($_manifest, true);

        $this->name = $manifest["package"]["name"];
        $this->version = $manifest["package"]["version"];
        $this->friendly_name = $manifest["package"]["friendly-name"];
        $this->author = $manifest["author"];
        $this->license = $manifest["package"]["license"];
        $this->files = $manifest["files"];
    }

    function checkFiles() {
        foreach($this->files as $key => $entry) {
            if(file_exists($entry['filename'])) {
                $this->files[$key]['exists'] = true;
                $this->files[$key]['current'] = sha1_file($entry['filename']) == $this->files[$key]['sha1'];
            } else {
                $this->files[$key]['exists'] = false;
            }
        }
        return $this;
    }
}

class PackageService {

    public function uploadPackage($file): bool
    {
        $upload_file = 'admin/packages/' . basename($file['name']);

        return move_uploaded_file($file['tmp_name'], $upload_file);
    }

    public function infoPackage($file): Package
    {
        return new Package(file_get_contents("admin/manifests/$file.json"));
    }

    public function readPackage($name) {
        $pkg = new \ZipArchive();
        if($pkg->open("admin/packages/$name.zip", \ZipArchive::RDONLY) === TRUE) {
            $manifest = json_decode($pkg->getFromName("$name/MANIFEST.json"));
            $fp = fopen("admin/manifests/$name.json", "w");
            fputs($fp, $manifest);
            return $manifest;
        } else {
            return false;
        }
    }

    public function listAvailablePackages() {
        $pkgList = [];
        foreach(glob("admin/manifests/*.json") as $package) {
            $pkgList[] = new Package(file_get_contents($package));
        }

        return $pkgList;
    }
}

$manifest = [
    "package" => [
        "name" => "space.bastie.plugin.ap",
        "friendly-name" => "AP Plugin",
        "version" => "0.1",
        "dependencies" => [],
        ],
    "author" => [
        "name" => "Bastian Luettig",
        "email" => "bastian.luettig@bastie.space",
        "website" => "www.bastie.space",
        "license" => "commercial",
    ],
    "files" => [
        [
            "filename" => "blubb",
            "sha1" => ""
        ]
    ]
];

