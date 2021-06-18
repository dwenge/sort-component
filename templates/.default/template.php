<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
if (empty($arResult['FIELDS'])) return;
?>

<div class="catalog-filter-box-items flex">
    
    <ul class="reset flex catalog-filter-list">
        <? if (!empty($arResult['FIELDS']['sort'])):
            $items = $arResult['FIELDS']['sort']['ITEMS'];
            $selectedVal = $items[$arResult['FIELDS']['sort']['SELECTED']];
            ?>
            <li>
                <div class="btn-group">
                    <button type="button" class="dropdown-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="icon icon-stats dropdown-button-ico"></i> Сортировка: <?= $selectedVal['NAME'] ?>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <? foreach ($items as $item):
                            if ($item['SELECTED']) continue;
                            ?>
                            <button class="dropdown-item" type="button" onclick="javascript:location.href='<?=$item['LINK']?>'"><?= $item['NAME'] ?></button>
                        <? endforeach; ?>
                    </div>
                </div>
            </li>
        <? endif; ?>
        <? if (!empty($arResult['FIELDS']['available'])): ?>
        <li>
            <? foreach ($arResult['FIELDS']['available']['ITEMS'] as $item): ?>
                <label class="form-group-checkbox normal" onclick="location.href='<?=$item['LINK']?>'">
                    <input type="checkbox" <?=$item['SELECTED'] ? 'checked' : ''?>>
                    <span><?= $item['NAME'] ?></span>
                </label>
            <? endforeach; ?>
        </li>
        <? endif; ?>
    </ul>
    <? if (!empty($arResult['FIELDS']['view'])):
        $items = $arResult['FIELDS']['view']['ITEMS'];
        ?>
    <ul class="reset flex catalog-filter-list">
        <? foreach ($items as $k => $item): ?>
        <li>
            <a href="<?= $item['LINK'] ?>" class="button-wiew normal <?= $item['SELECTED'] ? 'current' : '' ?>">
                <? if ($k == 'CARD'): ?>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" fill="#111111"/><rect width="8" height="8" fill="#00ADE3"/><rect width="8" height="8" fill="#004EC3"/><rect width="8" height="8" fill="#D7B266"/><rect width="8" height="8" fill="#D7B266"/><rect y="12" width="8" height="8" fill="#111111"/><rect y="12" width="8" height="8" fill="#00ADE3"/><rect y="12" width="8" height="8" fill="#004EC3"/><rect y="12" width="8" height="8" fill="#D7B266"/><rect y="12" width="8" height="8" fill="#D7B266"/><rect x="12" width="8" height="8" fill="#111111"/><rect x="12" width="8" height="8" fill="#00ADE3"/><rect x="12" width="8" height="8" fill="#004EC3"/><rect x="12" width="8" height="8" fill="#D7B266"/><rect x="12" width="8" height="8" fill="#D7B266"/><rect x="12" y="12" width="8" height="8" fill="#111111"/><rect x="12" y="12" width="8" height="8" fill="#00ADE3"/><rect x="12" y="12" width="8" height="8" fill="#004EC3"/><rect x="12" y="12" width="8" height="8" fill="#D7B266"/><rect x="12" y="12" width="8" height="8" fill="#D7B266"/></svg>
                <? else: ?>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="8" height="8" fill="#9A9A9A"/><rect y="12" width="8" height="8" fill="#9A9A9A"/><rect x="10" width="10" height="2" fill="#9A9A9A"/><rect x="10" y="12" width="10" height="2" fill="#9A9A9A"/><rect x="10" y="4" width="6" height="2" fill="#9A9A9A"/><rect x="10" y="16" width="6" height="2" fill="#9A9A9A"/></svg>
                <? endif; ?>
            </a>
        </li>
        <? endforeach; ?>
    </ul>
    <? endif; ?>
</div>
