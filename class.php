<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();


class ITJSort extends CBitrixComponent
{
    public function onPrepareComponentParams($arParams)
    {
        $arParams['UNIQUE_ID'] = !empty($arParams['UNIQUE_ID']) ? $arParams['UNIQUE_ID'] : 'global';
        return $arParams;
    }
    
    public function getVal($name)
    {
        if (!empty($_REQUEST[$name]))
            return $_REQUEST[$name];
        elseif ($_SESSION[$name])
            return $_SESSION[$name];
        return false;
    }
    
    public function getSelected($need, $arr)
    {
        return in_array($need, $arr) ? $need : reset($arr);
    }
    
    public function save($name, $value)
    {
        $_SESSION[$name] = $value;
    }
    
    public function linkToItems(&$arField)
    {
        global $APPLICATION;
        $controlName = $arField['CONTROL_NAME'];
        
        if ($arField['MULTIPLY']) {
            foreach ($arField['ITEMS'] as $val => $item) {
                $link = [];
                foreach ($arField['ITEMS'] as $v => $i) {
                    if ($val == $v) continue;
                    if ($i['SELECTED']) $link[] = "{$controlName}[]=$v";
                }
                if (!$item['SELECTED']) $link[] = "{$controlName}[]=$val";
                
                $arField['ITEMS'][$val]['LINK'] = $APPLICATION->GetCurPageParam(join('&', $link), [$controlName]);
            }
        } else {
            foreach ($arField['ITEMS'] as $val => $item) {
                if ($item['SELECTED']) {
                    $link = $APPLICATION->GetCurPageParam("", [$controlName]);
                } else {
                    $link = $APPLICATION->GetCurPageParam("$controlName=$val", [$controlName]);
                }
                $arField['ITEMS'][$val]['LINK'] = $link;
            }
        }
    }
    
    public function selectedToItems(&$arField)
    {
        $selectedVal = $this->getVal($arField['CONTROL_NAME']);
        $hasSelected = false;
        if ($arField['MULTIPLY']) {
            if (!is_array($selectedVal)) $selectedVal = [$selectedVal];
            foreach ($selectedVal as $sval) {
                if (!empty($arField['ITEMS'][$sval])) {
                    $arField['ITEMS'][$sval]['SELECTED'] = true;
                    $arField['SELECTED'][] = $sval;
                    $hasSelected = true;
                }
            }
            
            if ($hasSelected === false) {
                $arField['SELECTED'][] = array_keys($arField['ITEMS'])[0];
            }
        } else {
            if (is_array($selectedVal)) $selectedVal = reset($selectedVal);
            if (!empty($arField['ITEMS'][$selectedVal])) {
                $arField['ITEMS'][$selectedVal]['SELECTED'] = true;
                $arField['SELECTED'] = $selectedVal;
                $hasSelected = true;
            }
            
            if ($hasSelected === false) {
                $arField['SELECTED'] = array_keys($arField['ITEMS'])[0];
            }
        }
        
        if ($hasSelected === false) {
            $arField['ITEMS'][array_keys($arField['ITEMS'])[0]]['SELECTED'] = true;
        }
    }
    
    public function buildResult()
    {
        global $APPLICATION;
        
        $this->arResult = ['FIELDS' => []];
        foreach ($this->arParams['FIELDS'] as $fieldName => $arFieldValues) {
            $controlName = $fieldName . "_" . $this->arParams['UNIQUE_ID'];
            $multiply = in_array($fieldName, $this->arParams['MULTIPLY_FIELDS']);
            
            $this->arResult['FIELDS'][$fieldName] = [
                'CONTROL_NAME' => $controlName,
                'ITEMS'        => $arFieldValues,
                'MULTIPLY'     => $multiply,
            ];
        }
        
        foreach ($this->arResult['FIELDS'] as $fieldName => &$arFieldValue) {
            $this->selectedToItems($arFieldValue);
            
            $this->linkToItems($arFieldValue);
            
            $this->save($arFieldValue['CONTROL_NAME'], $arFieldValue['SELECTED']);
        }
        unset($arFieldValues);
    }
    
    public function buildReturnResult()
    {
        return array_map(function ($arField) {
            return $arField['SELECTED'];
        }, $this->arResult['FIELDS']);
    }
    
    public function executeComponent()
    {
        $this->buildResult();
        $this->includeComponentTemplate();
        
        return $this->buildReturnResult();
    }
}
