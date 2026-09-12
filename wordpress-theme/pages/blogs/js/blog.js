/**
 * Growtele Blog Page - Search, Pagination, Mobile Nav
 */

(function () {
  'use strict';

  const BLOGS = [
    {
      id: 1,
      page: 1,
      category: 'SMS',
      categoryClass: 'tag--sms',
      date: '16th June 2026',
      title: 'Top 5 advanced features for scalable SMS',
      excerpt: 'Scalable SMS service lets the business benefit from one of the innovative tools for engagement for consumers with the source.',
      bgImage: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Blog-02-Short.png',
    },
    {
      id: 2,
      page: 1,
      category: 'SMS',
      categoryClass: 'tag--sms',
      date: '11th June 2026',
      title: 'Using A2P Messaging to Retain Existing Customers',
      excerpt: 'The facts are there staring businesses in the face year after year yet still so many ignore them: their existing customers are most likely....',
      bgImage: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Blog-3.png',
    },
    {
      id: 3,
      page: 1,
      category: 'Whatsapp API',
      categoryClass: 'tag--whatsapp',
      date: '04th June 2026',
      title: 'The New Era of Customer Communication',
      excerpt: 'Customers expect instant, personalized, and convenient communication. Traditional channels often struggle to deliver the speed......',
      bgImage: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-599.png',
      whatsapp: true
    },
    {
      id: 4,
      page: 1,
      category: 'SMS',
      categoryClass: 'tag--sms',
      date: '22nd May 2026',
      title: 'How to: Get Started With SMS for Shipping + Delivery Notifications',
      excerpt: "SMS provides incredible advantages if you're shipping and making deliveries. Here are only a few matters you can do with....",
      bgImage: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Group-598.png',
    },
    {
      id: 5,
      page: 1,
      category: 'SMS',
      categoryClass: 'tag--sms',
      date: '16th June 2026',
      title: 'Top 5 advanced features for scalable SMS',
      excerpt: 'Scalable SMS service lets the business benefit from one of the innovative tools for engagement for consumers with the source.',
      bgImage: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Blog-02-Short.png',
    },
    {
      id: 6,
      page: 1,
      category: 'SMS',
      categoryClass: 'tag--sms',
      date: '11th June 2026',
      title: 'Using A2P Messaging to Retain Existing Customers',
      excerpt: 'The facts are there staring businesses in the face year after year yet still so many ignore them: their existing customers are most likely....',
      bgImage: 'https://listings.selectvia.com/wp-content/uploads/2026/09/Blog-3.png',
    },
    {
      id: 7,
      page: 2,
      category: 'SMS',
      categoryClass: 'tag--sms',
      date: '16th June 2026',
      title: 'Top 5 advanced features for scalable SMS',
      excerpt: 'Scalable SMS service lets the business benefit from one of the innovative tools for engagement for consumers with the source.',
      bgImage: 'assets/Rectangle 409.png',
      overlayClass: 'overlay--409',
      badge: { type: 'ewee1', src: 'assets/11111113EWEE 1.png' }
    },
    {
      id: 8,
      page: 2,
      category: 'Whatsapp API',
      categoryClass: 'tag--whatsapp',
      date: '04th June 2026',
      title: 'The New Era of Customer Communication',
      excerpt: 'Customers expect instant, personalized, and convenient communication. Traditional channels often struggle to deliver the speed......',
      bgImage: 'assets/Rectangle 465.png',
      overlayClass: 'overlay--465',
      badge: { type: 'image69', src: 'assets/image 69.png' },
      whatsapp: true
    },
    {
      id: 9,
      page: 2,
      category: 'SMS',
      categoryClass: 'tag--sms',
      date: '22nd May 2026',
      title: 'How to: Get Started With SMS for Shipping + Delivery Notifications',
      excerpt: "SMS provides incredible advantages if you're shipping and making deliveries. Here are only a few matters you can do with....",
      bgImage: 'assets/Rectangle 466.png',
      overlayClass: 'overlay--466',
      badge: { type: 'ewee6', src: 'assets/11111113EWEE 6.png' }
    },
    {
      id: 10,
      page: 2,
      category: 'SMS',
      categoryClass: 'tag--sms',
      date: '11th June 2026',
      title: 'Using A2P Messaging to Retain Existing Customers',
      excerpt: 'The facts are there staring businesses in the face year after year yet still so many ignore them: their existing customers are most likely....',
      bgImage: 'assets/Rectangle 464.png',
      overlayClass: 'overlay--464',
      badge: { type: 'ewee4', src: 'assets/11111113EWEE 4.png' }
    },
    {
      id: 11,
      page: 2,
      category: 'SMS',
      categoryClass: 'tag--sms',
      date: '16th June 2026',
      title: 'Top 5 advanced features for scalable SMS',
      excerpt: 'Scalable SMS service lets the business benefit from one of the innovative tools for engagement for consumers with the source.',
      bgImage: 'assets/Rectangle 409.png',
      overlayClass: 'overlay--409',
      badge: { type: 'ewee1', src: 'assets/11111113EWEE 7.png' }
    },
    {
      id: 12,
      page: 2,
      category: 'SMS',
      categoryClass: 'tag--sms',
      date: '11th June 2026',
      title: 'Using A2P Messaging to Retain Existing Customers',
      excerpt: 'The facts are there staring businesses in the face year after year yet still so many ignore them: their existing customers are most likely....',
      bgImage: 'assets/Rectangle 471.png',
      overlayClass: 'overlay--471',
      badge: { type: 'ewee4', src: 'assets/11111113EWEE 8.png' }
    },
    {
      id: 13,
      page: 3,
      category: 'Whatsapp API',
      categoryClass: 'tag--whatsapp',
      date: '04th June 2026',
      title: 'The New Era of Customer Communication',
      excerpt: 'Customers expect instant, personalized, and convenient communication. Traditional channels often struggle to deliver the speed......',
      bgImage: 'assets/Rectangle 465.png',
      overlayClass: 'overlay--465',
      badge: { type: 'image69', src: 'assets/image 69.png' },
      whatsapp: true
    },
    {
      id: 14,
      page: 3,
      category: 'SMS',
      categoryClass: 'tag--sms',
      date: '22nd May 2026',
      title: 'How to: Get Started With SMS for Shipping + Delivery Notifications',
      excerpt: "SMS provides incredible advantages if you're shipping and making deliveries. Here are only a few matters you can do with....",
      bgImage: 'assets/Rectangle 466.png',
      overlayClass: 'overlay--466',
      badge: { type: 'ewee6', src: 'assets/11111113EWEE 6.png' }
    },
    {
      id: 15,
      page: 3,
      category: 'SMS',
      categoryClass: 'tag--sms',
      date: '16th June 2026',
      title: 'Top 5 advanced features for scalable SMS',
      excerpt: 'Scalable SMS service lets the business benefit from one of the innovative tools for engagement for consumers with the source.',
      bgImage: 'assets/Rectangle 409.png',
      overlayClass: 'overlay--409',
      badge: { type: 'ewee1', src: 'assets/11111113EWEE 1.png' }
    },
    {
      id: 16,
      page: 3,
      category: 'SMS',
      categoryClass: 'tag--sms',
      date: '11th June 2026',
      title: 'Using A2P Messaging to Retain Existing Customers',
      excerpt: 'The facts are there staring businesses in the face year after year yet still so many ignore them: their existing customers are most likely....',
      bgImage: 'assets/Rectangle 464.png',
      overlayClass: 'overlay--464',
      badge: { type: 'ewee4', src: 'assets/11111113EWEE 4.png' }
    },
    {
      id: 17,
      page: 3,
      category: 'SMS',
      categoryClass: 'tag--sms',
      date: '16th June 2026',
      title: 'Top 5 advanced features for scalable SMS',
      excerpt: 'Scalable SMS service lets the business benefit from one of the innovative tools for engagement for consumers with the source.',
      bgImage: 'assets/Rectangle 409.png',
      overlayClass: 'overlay--409',
      badge: { type: 'ewee1', src: 'assets/11111113EWEE 7.png' }
    },
    {
      id: 18,
      page: 3,
      category: 'SMS',
      categoryClass: 'tag--sms',
      date: '11th June 2026',
      title: 'Using A2P Messaging to Retain Existing Customers',
      excerpt: 'The facts are there staring businesses in the face year after year yet still so many ignore them: their existing customers are most likely....',
      bgImage: 'assets/Rectangle 471.png',
      overlayClass: 'overlay--471',
      badge: { type: 'ewee4', src: 'assets/11111113EWEE 8.png' }
    }
  ];

  const TOTAL_PAGES = 3;
  const ITEMS_PER_PAGE = 6;

  let currentPage = 1;
  let searchQuery = '';

  const blogGrid = document.getElementById('blogGrid');
  const emptyState = document.getElementById('emptyState');
  const pagination = document.getElementById('pagination');
  const searchForm = document.getElementById('searchForm');
  const searchInput = document.getElementById('searchInput');
  const prevBtn = document.getElementById('prevPage');
  const nextBtn = document.getElementById('nextPage');
  const menuBtn = document.getElementById('menuBtn');
  const mainNav = document.getElementById('mainNav');

  function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
  }

  function renderBadge(blog) {
    const badge = blog.badge;
    if (!badge) return '';

    if (badge.type === 'image69') {
      return `
        <div class="blog-card__badge blog-card__badge--image69">
          <img src="${badge.src}" alt="">
        </div>
        ${blog.whatsapp ? `
        <div class="blog-card__badge blog-card__badge--whatsapp">
          <img src="assets/ellipse-106.svg" alt="" class="wa-circle">
          <img src="assets/image-70.png" alt="" width="47" height="47">
        </div>` : ''}`;
    }

    const classMap = {
      ewee1: 'blog-card__badge--ewee1',
      ewee4: 'blog-card__badge--ewee4',
      ewee6: 'blog-card__badge--ewee6'
    };

    return `<img src="${badge.src}" alt="" class="blog-card__badge ${classMap[badge.type] || 'blog-card__badge--ewee1'}">`;
  }

  function renderCard(blog) {
    const titleHtml = blog.title.includes('\n')
      ? blog.title.split('\n').map(escapeHtml).join('<br>')
      : escapeHtml(blog.title);

    return `
      <article class="blog-card" data-id="${blog.id}" data-search="${escapeHtml(
        (blog.title + ' ' + blog.excerpt + ' ' + blog.category + ' ' + blog.date).toLowerCase()
      )}">
        <div class="blog-card__image-wrap">
          <img src="${blog.bgImage}" alt="" class="bg">
          ${blog.overlayClass ? `<div class="overlay ${blog.overlayClass}"></div>` : ''}
          ${renderBadge(blog)}
        </div>
        <div class="blog-card__meta">
          <span class="tag ${blog.categoryClass}">${escapeHtml(blog.category)}</span>
          <span class="blog-card__date">${escapeHtml(blog.date)}</span>
        </div>
        <h3 class="blog-card__title">${titleHtml}</h3>
        <p class="blog-card__excerpt">${escapeHtml(blog.excerpt)}</p>
        <a href="#" class="read-more">Read More</a>
      </article>`;
  }

  function getFilteredBlogs() {
    const q = searchQuery.trim().toLowerCase();
    if (!q) {
      return BLOGS.filter(function (b) { return b.page === currentPage; });
    }
    return BLOGS.filter(function (b) {
      const haystack = (b.title + ' ' + b.excerpt + ' ' + b.category + ' ' + b.date).toLowerCase();
      return haystack.indexOf(q) !== -1;
    });
  }

  function renderGrid() {
    const blogs = getFilteredBlogs();
    blogGrid.innerHTML = blogs.map(renderCard).join('');

    const isSearching = searchQuery.trim().length > 0;
    emptyState.hidden = blogs.length > 0;
    pagination.hidden = isSearching;

    if (!isSearching) {
      updatePaginationUI();
    }
  }

  function updatePaginationUI() {
    const pageButtons = pagination.querySelectorAll('.pagination__num');
    pageButtons.forEach(function (btn) {
      const page = parseInt(btn.dataset.page, 10);
      btn.classList.toggle('pagination__num--active', page === currentPage);
    });

    prevBtn.disabled = currentPage <= 1;
    nextBtn.disabled = currentPage >= TOTAL_PAGES;
  }

  function goToPage(page) {
    if (page < 1 || page > TOTAL_PAGES) return;
    currentPage = page;
    searchQuery = '';
    searchInput.value = '';
    renderGrid();
    blogGrid.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  searchForm.addEventListener('submit', function (e) {
    e.preventDefault();
    searchQuery = searchInput.value;
    currentPage = 1;
    renderGrid();
  });

  searchInput.addEventListener('input', function () {
    searchQuery = searchInput.value;
    renderGrid();
  });

  pagination.addEventListener('click', function (e) {
    const numBtn = e.target.closest('.pagination__num');
    if (numBtn) {
      goToPage(parseInt(numBtn.dataset.page, 10));
      return;
    }
    if (e.target.closest('#prevPage') && currentPage > 1) {
      goToPage(currentPage - 1);
    }
    if (e.target.closest('#nextPage') && currentPage < TOTAL_PAGES) {
      goToPage(currentPage + 1);
    }
  });

  if (menuBtn && mainNav) {
    menuBtn.addEventListener('click', function () {
      const isOpen = mainNav.classList.toggle('is-open');
      menuBtn.classList.toggle('is-open', isOpen);
      menuBtn.setAttribute('aria-expanded', String(isOpen));
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });

    mainNav.querySelectorAll('a').forEach(function (link) {
      link.addEventListener('click', function () {
        mainNav.classList.remove('is-open');
        menuBtn.classList.remove('is-open');
        menuBtn.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      });
    });
  }

  renderGrid();
})();
