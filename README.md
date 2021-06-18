
# Компонент сортировки
## Параметры компонента:
- UNIQUE_ID - Уникальная строка. Используется, если на странице присутствуют несколько сортировок
- FIELDS - Поля для сортировки
- MULTIPLY_FIELDS - Содержит коды полей множественного выбора

## Пример:
```php
$sort = $APPLICATION->IncludeComponent('itjust:sort', '', [
    'UNIQUE_ID' => 'catalog',
    'FIELDS' => [
        'sort' => [                         // Код поля
            'PRICE_DESC' => [               // Код значения поля
                'NAME' => 'Сначала дороже'  // Массив может содержать любые данные. Они используется в шаблоне. !!!НЕ ИСПОЛЬЗОВАТЬ SELECTED!!!
            ],
            'PRICE_ASC' => ['NAME' => 'Сначала дешевле'],
            'NAME' => ['NAME' => 'По имени'],
        ],
        'available' => [
            'Y' => ['NAME' => 'В наличии'],
            'N' => ['NAME' => 'Под заказ'],
        ],
        'view' => [
            'CARD' => ['NAME' => 'Плитка'],
            'LINE' => ['NAME' => 'Линия']
        ]
    ],
    'MULTIPLY_FIELDS' => ['available'],
], $component);
```

Результат:
```php
// Первое значение поля по-умолчанию selected
array(
    'sort' => 'PRICE_DESC',
    'available' => ['Y'], // MULTIPLY_FIELDS
    'view' => 'CARD'
);
```

## Использование
```php
// Значение по-умолчанию
switch ($sort['sort']) {
    case 'PRICE_DESC':
        $elementSortField = 'CATALOG_PRICE_1';
        $elementSortOrder = 'DESC';
        break;
    case 'PRICE_ASC':
        $elementSortField = 'CATALOG_PRICE_1';
        $elementSortOrder = 'ASC';
        break;
    case 'NAME':
        $elementSortField = 'NAME';
        $elementSortOrder = 'ASC';
        break;
    default: // Значение по-умолчанию
        $elementSortField = $arParams['ELEMENT_SORT_FIELD'];
        $elementSortOrder = $arParams['ELEMENT_SORT_ORDER'];
        break;
}

if (!(in_array('Y',$sort['available']) && in_array('N', $sort['available']))) {
    $GLOBALS[$arParams['FILTER_NAME']]['AVAILABLE'] = in_array('N', $sort['available']) ? 'N' : 'Y';
}

// Подключение компонента
$APPLICATION->IncludeComponent(
    'bitrix:catalog.section',
    'catalog',
    array(
        'VIEW' => $sort['view'],
        'ELEMENT_SORT_FIELD' => $elementSortField,
        'ELEMENT_SORT_ORDER' => $elementSortOrder,
        'FILTER_NAME' => $arParams['FILTER_NAME'],
        ...
    )
)
```