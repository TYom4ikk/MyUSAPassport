<div class="page-header">
    <div class="page-header-icon"></div>
    <div class="page-header-text">
        <h1>Модерация отзывов</h1>
        <small>Управление отзывами пользователей</small>
    </div>
</div>

<div class="admin-stats">
    <div class="stat-card">
        <h3>Всего отзывов</h3>
        <span class="stat-number"><?php echo $stats['total']; ?></span>
    </div>
    <div class="stat-card">
        <h3>Положительные</h3>
        <span class="stat-number"><?php echo $stats['positive']; ?></span>
    </div>
    <div class="stat-card">
        <h3>Средний рейтинг</h3>
        <span class="stat-number"><?php echo $stats['avg_rating'] ? number_format($stats['avg_rating'], 1) : '0.0'; ?></span>
    </div>
    <div class="stat-card">
        <h3>Избранные</h3>
        <span class="stat-number"><?php echo $stats['featured']; ?></span>
    </div>
</div>

<div class="testimonials-admin">
    <div class="testimonials-list" id="testimonialsList">
        <?php if (!empty($testimonials)): ?>
            <?php foreach ($testimonials as $testimonial): ?>
                <div class="testimonial-admin-card">
                    <div class="testimonial-header">
                        <div class="user-info">
                            <h4><?php echo htmlspecialchars($testimonial['user_name']); ?></h4>
                            <p><?php echo htmlspecialchars($testimonial['email']); ?></p>
                            <div class="rating">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span class="star <?php echo $i <= $testimonial['rating'] ? 'filled' : ''; ?>">★</span>
                                <?php endfor; ?>
                                <span><?php echo $testimonial['rating']; ?>/5</span>
                            </div>
                        </div>
                        <div class="testimonial-meta">
                            <span class="date"><?php echo date('d.m.Y H:i', strtotime($testimonial['created_at'])); ?></span>
                            <?php
                            $statusClass = '';
                            $statusText = '';
                            if ($testimonial['status'] === 'pending') {
                                $statusClass = 'status-new';
                                $statusText = 'Новый';
                            } elseif ($testimonial['status'] === 'approved') {
                                $statusClass = 'status-approved';
                                $statusText = 'Одобрен';
                            } elseif ($testimonial['status'] === 'featured') {
                                $statusClass = 'status-featured';
                                $statusText = 'Избранный';
                            }
                            ?>
                            <span class="status-badge <?php echo $statusClass; ?>"><?php echo $statusText; ?></span>
                        </div>
                    </div>
                    
                    <div class="testimonial-content">
                        <p><?php echo htmlspecialchars($testimonial['content']); ?></p>
                    </div>
                    
                    <?php if (!empty($testimonial['avatar'])): ?>
                        <div class="user-avatar">
                            <img src="/<?php echo htmlspecialchars($testimonial['avatar']); ?>" alt="Аватар">
                        </div>
                    <?php endif; ?>
                    
                    <div class="testimonial-actions">
                        <?php if ($testimonial['status'] === 'pending'): ?>
                            <button class="btn btn-success approve-btn" 
                                    data-id="<?php echo $testimonial['id']; ?>">
                                Одобрить
                            </button>
                            <button class="btn btn-danger reject-btn" 
                                    data-id="<?php echo $testimonial['id']; ?>">
                                Отклонить
                            </button>
                        <?php else: ?>
                            <button class="btn btn-danger reject-btn" 
                                    data-id="<?php echo $testimonial['id']; ?>">
                                Удалить
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="no-testimonials">
                <p>Пока нет отзывов для модерации.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
.admin-stats {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

.stat-card h3 {
    margin: 0 0 10px 0;
    color: #666;
    font-size: 14px;
    text-transform: uppercase;
}

.stat-number {
    font-size: 32px;
    font-weight: bold;
    color: #4a90e2;
}

.testimonials-admin {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.testimonials-list {
    max-height: 600px;
    overflow-y: auto;
    padding-right: 10px;
}

/* Стили для скроллбара */
.testimonials-list::-webkit-scrollbar {
    width: 8px;
}

.testimonials-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.testimonials-list::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 4px;
}

.testimonials-list::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}

.testimonial-admin-card {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 15px;
}

.testimonial-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
}

.user-info h4 {
    margin: 0 0 5px 0;
    color: #333;
}

.user-info p {
    margin: 0 0 10px 0;
    color: #666;
    font-size: 14px;
}

.rating {
    display: flex;
    align-items: center;
    gap: 5px;
}

.rating .star {
    color: #ddd;
    font-size: 16px;
}

.rating .star.filled {
    color: #ffd700;
}

.testimonial-meta {
    text-align: right;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 5px;
}

.date {
    color: #999;
    font-size: 14px;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
    font-weight: bold;
    text-transform: uppercase;
}

.status-new {
    background: #ffc107;
    color: #333;
}

.status-approved {
    background: #28a745;
    color: white;
}

.status-featured {
    background: #007bff;
    color: white;
}

.testimonial-content {
    margin-bottom: 15px;
    line-height: 1.6;
    color: #555;
}

.user-avatar {
    margin-bottom: 15px;
}

.user-avatar img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    object-fit: cover;
}

.testimonial-actions {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.btn {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background 0.3s;
}

.btn-success {
    background: #28a745;
    color: white;
}

.btn-success:hover {
    background: #218838;
}

.btn-danger {
    background: #dc3545;
    color: white;
}

.btn-danger:hover {
    background: #c82333;
}

.no-testimonials {
    text-align: center;
    padding: 40px;
    color: #666;
}

@media (max-width: 768px) {
    .testimonial-header {
        flex-direction: column;
        gap: 10px;
    }
    
    .testimonial-meta {
        text-align: left;
        align-items: flex-start;
    }
    
    .testimonial-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
    }
    
    .testimonials-list {
        max-height: 500px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Одобрение отзыва
    document.querySelectorAll('.approve-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            
            fetch('/index.php?route=admin/testimonials/approve', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `testimonial_id=${id}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert(data.message || 'Ошибка');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Произошла ошибка');
            });
        });
    });
    
    // Удаление/отклонение отзыва
    document.querySelectorAll('.reject-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.textContent.trim().toLowerCase();
            const confirmMessage = action === 'отклонить' ? 
                'Вы уверены, что хотите отклонить этот отзыв?' : 
                'Вы уверены, что хотите удалить этот отзыв?';
            
            if (confirm(confirmMessage)) {
                const id = this.dataset.id;
                
                fetch('/index.php?route=admin/testimonials/reject', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `testimonial_id=${id}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message || 'Ошибка');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Произошла ошибка');
                });
            }
        });
    });
});
</script>
