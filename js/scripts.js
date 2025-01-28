// scripts.js

// Функция для отображения уведомлений
function showNotification(message, type = 'info') {
	const notifications = document.getElementById('notifications')
	if (!notifications) return

	const notification = document.createElement('div')
	notification.classList.add('notification')
	notification.classList.add(type)
	notification.textContent = message
	notifications.appendChild(notification)

	// Автоматическое удаление уведомления через 5 секунд
	setTimeout(() => {
		notification.remove()
	}, 5000)
}

// Валидация формы регистрации
function validateRegistrationForm() {
	const username = document.forms['registrationForm']['username'].value.trim()
	const email = document.forms['registrationForm']['email'].value.trim()
	const password = document.forms['registrationForm']['password'].value
	const confirmPassword =
		document.forms['registrationForm']['confirmPassword'].value

	if (
		username === '' ||
		email === '' ||
		password === '' ||
		confirmPassword === ''
	) {
		showNotification('Пожалуйста, заполните все поля.', 'error')
		return false
	}

	if (password !== confirmPassword) {
		showNotification('Пароли не совпадают.', 'error')
		return false
	}

	// Дополнительные проверки email
	const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
	if (!emailPattern.test(email)) {
		showNotification('Пожалуйста, введите корректный email.', 'error')
		return false
	}

	return true
}

// Валидация формы входа
function validateLoginForm() {
	const email = document.forms['loginForm']['email'].value.trim()
	const password = document.forms['loginForm']['password'].value

	if (email === '' || password === '') {
		showNotification('Пожалуйста, заполните все поля.', 'error')
		return false
	}

	return true
}

// Валидация формы обратной связи
function validateFeedbackForm() {
	const message = document.forms['feedbackForm']['message'].value.trim()

	if (message === '') {
		showNotification('Пожалуйста, введите сообщение.', 'error')
		return false
	}

	return true
}

// Обработчик отправки формы регистрации
document.addEventListener('DOMContentLoaded', () => {
	const registrationForm = document.getElementById('registrationForm')
	if (registrationForm) {
		registrationForm.addEventListener('submit', e => {
			if (!validateRegistrationForm()) {
				e.preventDefault()
			}
		})
	}

	const loginForm = document.getElementById('loginForm')
	if (loginForm) {
		loginForm.addEventListener('submit', e => {
			if (!validateLoginForm()) {
				e.preventDefault()
			}
		})
	}

	const feedbackForm = document.getElementById('feedbackForm')
	if (feedbackForm) {
		feedbackForm.addEventListener('submit', e => {
			if (!validateFeedbackForm()) {
				e.preventDefault()
			}
		})
	}
})
$(document).ready(function () {
	// Дополнительные скрипты для интерактивности
})
