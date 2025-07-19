<?php
// 模型配置
$models = [
    [
        'value' => 'Flux-Dev',
        'label' => 'Flux-Dev'
    ],
    [
        'value' => 'HiDream-full-fp8',
        'label' => 'HiDream-full-fp8'
    ],
    [
        'value' => 'Stable-Diffusion-3.5',
        'label' => 'Stable-Diffusion-3.5'
    ]
];

// 输出JSON格式
header('Content-Type: application/json');
echo json_encode($models);
?>
    
