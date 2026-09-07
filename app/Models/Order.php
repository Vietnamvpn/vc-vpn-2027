<?php

namespace App\Models;

class Order extends BaseModel
{
    protected string $table = 'vc_orders';

    public function getByUserId(int $userId): array
    {
        $stmt = self::$db->prepare("SELECT * FROM `{$this->table}` WHERE `user_id` = :user_id ORDER BY `id` DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll() ?: [];
    }

    /**
     * Lấy danh sách doanh thu theo từng ngày trong tháng/năm chỉ định
     */
    public function getDailyRevenueByMonth(int $year, int $month): array
    {
        $stmt = self::$db->prepare("
            SELECT DAY(created_at) as day_num, SUM(total_amount) as total
            FROM `{$this->table}`
            WHERE payment_status = 'completed'
              AND YEAR(created_at) = :year
              AND MONTH(created_at) = :month
            GROUP BY DAY(created_at)
        ");
        $stmt->execute(['year' => $year, 'month' => $month]);
        $results = $stmt->fetchAll() ?: [];

        $daysInMonth = (int)date('t', mktime(0, 0, 0, $month, 1, $year));
        $dailyData = array_fill(1, $daysInMonth, 0.0);

        foreach ($results as $row) {
            $day = (int)$row['day_num'];
            if ($day <= $daysInMonth) {
                $dailyData[$day] = (float)$row['total'];
            }
        }

        return array_values($dailyData);
    }

    /**
     * Lấy tổng doanh thu của một tháng cụ thể
     */
    public function getMonthlyRevenue(int $year, int $month): float
    {
        $stmt = self::$db->prepare("
            SELECT SUM(total_amount) as total
            FROM `{$this->table}`
            WHERE payment_status = 'completed'
              AND YEAR(created_at) = :year
              AND MONTH(created_at) = :month
        ");
        $stmt->execute(['year' => $year, 'month' => $month]);
        $result = $stmt->fetch();

        return (float)($result['total'] ?? 0.0);
    }

    /**
     * Lấy danh sách đơn hàng gần đây
     */
    public function getRecentOrders(int $limit = 10): array
    {
        $stmt = self::$db->prepare("
            SELECT o.*, u.username
            FROM `{$this->table}` o
            LEFT JOIN `vc_users` u ON o.user_id = u.id
            ORDER BY o.id DESC
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll() ?: [];
    }
}