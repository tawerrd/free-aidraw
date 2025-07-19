<?php
// 模型配置
$models = [
    [
        'value' => 'Flux-Dev',
        'label' => 'Flux-Dev'
    ],
    [
        'value' => 'DreamShaper',
        'label' => 'DreamShaper'
    ],
    [
        'value' => 'StableDiffusion',
        'label' => 'StableDiffusion'
    ],
    [
        'value' => 'WaifuDiffusion',
        'label' => 'WaifuDiffusion'
    ],
    [
        'value' => 'OpenJourney',
        'label' => 'OpenJourney'
    ]
];

// 输出JSON格式
header('Content-Type: application/json');
echo json_encode($models);
?>
    
