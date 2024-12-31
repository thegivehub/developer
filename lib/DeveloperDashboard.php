<?php
// lib/DeveloperDashboard.php

class DeveloperDashboard {
    private $db;
    private $developerId;
    
    public function __construct($developerId) {
        $this->db = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
            DB_USER,
            DB_PASS
        );
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->developerId = $developerId;
    }
    
    public function getOverviewData() {
        try {
            $data = [
                'metrics' => $this->getMetrics(),
                'recentCalls' => $this->getRecentApiCalls(),
                'apiKeys' => $this->getApiKeys(),
                'usageStats' => $this->getUsageStats()
            ];
            
            return [
                'success' => true,
                'data' => $data
            ];
        } catch (Exception $e) {
            error_log("Failed to get dashboard data: " . $e->getMessage());
            return [
                'success' => false,
                'error' => 'Failed to load dashboard data'
            ];
        }
    }
    
    private function getMetrics() {
        // Get last 24 hours API calls
        $stmt = $this->db->prepare("
            SELECT 
                COUNT(*) as total_calls,
                AVG(response_time) as avg_response_time,
                SUM(CASE WHEN response_code >= 400 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as error_rate
            FROM api_usage_logs
            WHERE api_key_id IN (
                SELECT id FROM developer_api_keys WHERE developer_id = ?
            )
            AND timestamp >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
        ");
        
        $stmt->execute([$this->developerId]);
        $metrics = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Get previous 24 hours for comparison
        $stmt = $this->db->prepare("
            SELECT 
                COUNT(*) as total_calls,
                AVG(response_time) as avg_response_time,
                SUM(CASE WHEN response_code >= 400 THEN 1 ELSE 0 END) * 100.0 / COUNT(*) as error_rate
            FROM api_usage_logs
            WHERE api_key_id IN (
                SELECT id FROM developer_api_keys WHERE developer_id = ?
            )
            AND timestamp BETWEEN 
                DATE_SUB(NOW(), INTERVAL 48 HOUR) AND
                DATE_SUB(NOW(), INTERVAL 24 HOUR)
        ");
        
        $stmt->execute([$this->developerId]);
        $previous = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Calculate changes
        return [
            'current' => [
                'total_calls' => (int)$metrics['total_calls'],
                'avg_response_time' => round($metrics['avg_response_time']),
                'error_rate' => round($metrics['error_rate'], 2)
            ],
            'changes' => [
                'calls' => $this->calculatePercentageChange(
                    $previous['total_calls'], 
                    $metrics['total_calls']
                ),
                'response_time' => $this->calculatePercentageChange(
                    $previous['avg_response_time'], 
                    $metrics['avg_response_time']
                ),
                'error_rate' => $this->calculatePercentageChange(
                    $previous['error_rate'], 
                    $metrics['error_rate']
                )
            ]
        ];
    }
    
    private function getRecentApiCalls($limit = 10) {
        $stmt = $this->db->prepare("
            SELECT 
                l.endpoint,
                l.method,
                l.response_code,
                l.response_time,
                l.timestamp
            FROM api_usage_logs l
            INNER JOIN developer_api_keys k ON l.api_key_id = k.id
            WHERE k.developer_id = ?
            ORDER BY l.timestamp DESC
            LIMIT ?
        ");
        
        $stmt->execute([$this->developerId, $limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function getApiKeys() {
        $stmt = $this->db->prepare("
            SELECT 
                id,
                api_key,
                name,
                environment,
                status,
                created_at,
                last_used_at
            FROM developer_api_keys
            WHERE developer_id = ?
        ");
        
        $stmt->execute([$this->developerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function getUsageStats() {
        // Get hourly stats for the last 24 hours
        $stmt = $this->db->prepare("
            SELECT 
                DATE_FORMAT(timestamp, '%Y-%m-%d %H:00:00') as hour,
                COUNT(*) as calls,
                AVG(response_time) as avg_response_time,
                SUM(CASE WHEN response_code >= 400 THEN 1 ELSE 0 END) as errors
            FROM api_usage_logs l
            INNER JOIN developer_api_keys k ON l.api_key_id = k.id
            WHERE k.developer_id = ?
            AND timestamp >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
            GROUP BY DATE_FORMAT(timestamp, '%Y-%m-%d %H:00:00')
            ORDER BY hour
        ");
        
        $stmt->execute([$this->developerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    private function calculatePercentageChange($old, $new) {
        if ($old == 0) return 100;
        return round((($new - $old) / $old) * 100, 1);
    }
}
