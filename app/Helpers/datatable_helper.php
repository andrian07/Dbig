<?php
function button_edit($prop)
{
    return '<button ' . $prop . ' class="btn btn-sm btn-warning btnedit" data-toggle="tooltip" data-placement="top" data-title="Edit"><i class="fas fa-edit"></i></button>';
}

function button_delete($prop)
{
    return '<button ' . $prop . ' class="btn btn-sm btn-danger btndelete" data-toggle="tooltip" data-placement="top" data-title="Hapus"><i class="fas fa-trash"></i></button>';
}


function button_print($prop)
{
    return '<button ' . $prop . ' class="btn btn-sm btn-default btnprint" data-toggle="tooltip" data-placement="top" data-title="Print"><i class="fas fa-print"></i></button>';
}


if (!function_exists('fancy_image')) {
    function fancy_image($caption, $imageUrl, $thumbUrl, $imageClass = '')
    {
        $result   = [];
        $result[] = '<a href="' . $imageUrl . '" data-fancybox data-caption="' . $caption . '">';
        $result[] = '<img class="' . $imageClass . '" src="' . $thumbUrl . '">';
        $result[] = '</a>';
        return implode('', $result);
    }
}

if (!function_exists('badge')) {
    function badge($text, $badgeStyle = '', $badgeClass = '')
    {
        return "<span class=\"badge badge-$badgeStyle $badgeClass \">$text</span>";
    }
}


if (!function_exists('activeSymbol')) {
    function activeSymbol($x)
    {
        if ($x) {
            return badge('<i class="fas fa-check-circle"></i>', 'success');
        } else {
            return badge('<i class="fas fa-times-circle"></i>', 'danger');
        }
    }
}
