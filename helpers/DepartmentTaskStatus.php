<?php
if (!function_exists('departmentTaskStatus')) {
    /**
     * Trả về [text, classCSS] theo style ('label' | 'badge')
     * Ví dụ: departmentTaskStatus('pending', 'badge')
     *        => ['Chờ duyệt', 'badge-warning']
     */
 function departmentTaskStatus(string $status, string $style = 'badge'): array
{
    $status = strtolower(trim($status));   // ✅ chuẩn hoá

    $map = [
        'pending'     => ['Chờ duyệt',      ['label'=>'bg-grey',  'badge'=>'badge-warning']],
        'in_progress' => ['Đang thực hiện', ['label'=>'bg-blue',  'badge'=>'badge-info']],
        'approved'    => ['Đã duyệt',       ['label'=>'bg-green', 'badge'=>'badge-success']],
        'rejected'    => ['Từ chối',        ['label'=>'bg-red',   'badge'=>'badge-danger']],
        'completed'   => ['Hoàn thành',     ['label'=>'bg-teal',  'badge'=>'badge-success']],
        'cancelled'   => ['Đã hủy',         ['label'=>'bg-black', 'badge'=>'badge-dark']],
        'canceled'    => ['Đã hủy',         ['label'=>'bg-black', 'badge'=>'badge-dark']], // US spelling
    ];

    if (!isset($map[$status])) {
        return ['Đã hủy', $style === 'label' ? 'bg-black' : 'badge-secondary'];
    }

    return [$map[$status][0], $map[$status][1][$style]];
}

}



