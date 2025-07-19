<?php
// 确保脚本不会超时
set_time_limit(300);

// 错误处理函数
function handleError($message, $statusCode = 500) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode(['error' => $message]);
    exit;
}

// 获取请求数据
$requestData = json_decode(file_get_contents('php://input'), true);

if ($requestData === null) {
    handleError('无效的JSON数据', 400);
}

// 验证必要的参数
$requiredFields = ['prompt', 'width', 'height', 'steps', 'seed', 'batch_size', 'model'];
foreach ($requiredFields as $field) {
    if (!isset($requestData[$field])) {
        handleError("缺少必要参数: $field", 400);
    }
}

// API端点
$apiUrl = 'https://dreamify.slmnb.cn/api/generate';

// 准备请求数据
$postData = json_encode([
    'prompt' => $requestData['prompt'],
    'width' => (int)$requestData['width'],
    'height' => (int)$requestData['height'],
    'steps' => (int)$requestData['steps'],
    'seed' => (int)$requestData['seed'],
    'batch_size' => (int)$requestData['batch_size'],
    'model' => $requestData['model'],
    'images' => []
]);

// 初始化cURL会话
$ch = curl_init($apiUrl);

// 设置cURL选项
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($postData)
]);
curl_setopt($ch, CURLOPT_TIMEOUT, 300);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 注意：生产环境中应验证SSL证书

// 执行cURL请求
$response = curl_exec($ch);

// 检查错误
if (curl_errno($ch)) {
    handleError('API请求失败: ' . curl_error($ch));
}

// 获取HTTP状态码
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// 关闭cURL会话
curl_close($ch);

// 处理API响应
if ($httpCode !== 200) {
    handleError("API返回错误状态码: $httpCode", $httpCode);
}

// 解析API响应
$apiResult = json_decode($response, true);

if ($apiResult === null) {
    handleError('无法解析API响应', 500);
}

if (!isset($apiResult['imageUrl'])) {
    handleError('API响应格式不正确', 500);
}

// 返回结果
header('Content-Type: application/json');
echo json_encode([
    'imageUrl' => $apiResult['imageUrl']
]);
?>
    
