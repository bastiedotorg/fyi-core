<?php
/**
 * FYI Loginscript
 * (c) 2021 by bastie.space <bastian.luettig@bastie.space>
 * www.bastie.space
 */


namespace App\Models;


class ConfigMapper extends DatabaseMapper
{
    protected string $table = "config_items";

    public function getConfigItems()
    {
        return $this->List($this->table, "", "`group_name`, `label` ASC");
    }

    public function getGrouped() {
        $list = [];
        $groups = $this->getGroups();

        foreach($groups as $_group) {
            $list[$_group['group_name']] = [];
        }
        $data = $this->getConfigItems();
        foreach($data AS $item) {
            $item['field_id']= $item['group_name'] . "_" . $item['config_key'];

            $list[$item['group_name']][] = $item;
        }
        return $list;
    }

    public function getConfigItemsByGroup($group_name)
    {
        return $this->List($this->table, "group_name='$group_name'", "`label` ASC");
    }

    public function getGroups() {
        return $this->QueryList("SELECT `group_name` FROM `$this->table` GROUP BY `group_name` ORDER BY `group_name`");
    }

    public function storeConfigData($post_data)
    {
        $fp = fopen('config/variable_config.inc.php', 'w');
        fputs($fp, '<?php'.PHP_EOL);
        fputs($fp, '/**'.PHP_EOL);
        fputs($fp, ' * FYI Loginscript'.PHP_EOL);
        fputs($fp, ' * (c) 2021 by bastie.space <bastian.luettig@bastie.space>'.PHP_EOL);
        fputs($fp, ' * www.bastie.space'.PHP_EOL);
        fputs($fp, ' * Created on: '.date("Y-m-d H:i:s").PHP_EOL);
        fputs($fp, ' */'.PHP_EOL.PHP_EOL);
        $groups = $this->getGroups();
        foreach ($groups as $_group) {
            $group = $_group['group_name'];
            fputs($fp, ''.PHP_EOL.PHP_EOL);
            fputs($fp, 'const ' . strtoupper($group) . ' = array('.PHP_EOL);
            $items = $this->QueryList("SELECT `config_key`, `default_value`,`current_value` FROM `$this->table` WHERE `group_name`='$group' ORDER BY `config_key`");
            foreach ($items as $_item) {
                $item = $_item[0];
                $key = $group . "_" . $item;
                if (!isset($post_data[$key])) {
                    $value = $_item['current_value'];
                } else {
                    $value = $post_data[$key];
                    $this->Update($this->table, ["current_value" => $value], "`group_name` = '$group' AND `config_key` = '$item'", true);
                }

                fputs($fp, '"' . $item . '" => "' . $value . '",'.PHP_EOL);
            }
            fputs($fp, ');'.PHP_EOL.PHP_EOL);
        }
    }

    public function addConfigItem($group_name, $label, $default_value, $config_key, $help_text, $package)
    {
        $this->Insert("config_items", [
            "group_name" => $group_name,
            "label" => $label,
            "default_value" => $default_value,
            "current_value" => $default_value,
            "config_key" => $config_key,
            "help_text" => $help_text,
            "package" => $package
        ]);
    }

    public function removeConfigItems($package) {
        $this->Delete($this->table, "`package` = '$package'");
    }

    public function createTable()
    {
        $this->db->query("CREATE TABLE `config_items` (
	`group_name` VARCHAR(100) NOT NULL,
	`label` VARCHAR(100) NOT NULL,
	`default_value` VARCHAR(100) NOT NULL,
	`current_value` VARCHAR(100) NOT NULL,
	`config_key` VARCHAR(100) NOT NULL,
	`help_text` VARCHAR(100) NOT NULL,
	`package` VARCHAR(100) NOT NULL
);");
    }
}