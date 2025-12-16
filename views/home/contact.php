<h1>Форма обратной связи</h1>
<p id="contact-form-message"><?php echo !empty($info) ? htmlspecialchars($info) : ''; ?></p>

<form method="post" action="index.php?route=contact" id="contact-form">
    <div class="form-group">
        <label for="message">Сообщение:</label>
        <textarea id="message" name="message" rows="5" required placeholder="Опишите ваш вопрос или опыт..."><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
    </div>
    
    <div class="form-group">
        <label>Оцените сервис:</label>
        <div class="rating-stars" id="ratingStars">
            <span class="star" data-rating="1">★</span>
            <span class="star" data-rating="2">★</span>
            <span class="star" data-rating="3">★</span>
            <span class="star" data-rating="4">★</span>
            <span class="star" data-rating="5">★</span>
        </div>
        <input type="hidden" name="rating" id="ratingInput" value="0">
    </div>
    
    <button type="submit">Отправить</button>
</form>

<style>
.rating-section {
    margin: 15px 0;
}

.rating-stars {
    display: flex;
    flex-direction: row-reverse;
    gap: 5px;
    margin: 10px 0;
}

.rating-stars input[type="radio"] {
    display: none;
}

.rating-stars .star {
    font-size: 24px;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s;
}

.rating-stars .star:hover,
.rating-stars .star:hover ~ .star {
    color: #ffd700;
}

.rating-stars input[type="radio"]:checked ~ .star {
    color: #ffd700;
}

#isTestimonial {
    margin-right: 5px;
}

#isTestimonial + label {
    font-size: 14px;
    color: #666;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contact-form');
    const messageTextarea = form.querySelector('textarea[name="message"]');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Предотвращаем обычную отправку
        
        const message = messageTextarea.value.trim();
        if (!message) {
            alert('Пожалуйста, введите сообщение');
            messageTextarea.focus();
            return;
        }
        
        // Блокируем кнопку чтобы избежать двойной отправки
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Отправка...';
        
        // AJAX submission
        const formData = new FormData(form);
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('contact-form-message').textContent = data.message;
            if (data.success) {
                form.reset();
                // Reset stars
                document.querySelectorAll('.rating-stars .star').forEach(star => {
                    star.style.color = '#ddd';
                });
                document.getElementById('ratingInput').value = '0';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('contact-form-message').textContent = 'Произошла ошибка при отправке';
        })
        .finally(() => {
            // Разблокируем кнопку
            submitBtn.disabled = false;
            submitBtn.textContent = 'Отправить';
        });
    });
    
    // Star rating interaction
    const stars = document.querySelectorAll('.rating-stars .star');
    const ratingInput = document.getElementById('ratingInput');
    
    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            const rating = 5 - index;
            ratingInput.value = rating;
            updateStarDisplay(rating);
        });
        
        star.addEventListener('mouseenter', function() {
            const rating = 5 - index;
            updateStarDisplay(rating);
        });
    });
    
    document.querySelector('.rating-stars').addEventListener('mouseleave', function() {
        const currentRating = parseInt(ratingInput.value) || 0;
        updateStarDisplay(currentRating);
    });
    
    function updateStarDisplay(rating) {
        stars.forEach((star, index) => {
            if (5 - index <= rating) {
                star.style.color = '#ffd700';
            } else {
                star.style.color = '#ddd';
            }
        });
    }
});
</script>
