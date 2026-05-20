lucide.createIcons();

// NAVBAR SCROLL EFFECT

const navbar = document.querySelector('.navbar');

window.addEventListener('scroll', () => {

  if(window.scrollY > 30){

    navbar.style.background =
      'rgba(3, 10, 7, .82)';

    navbar.style.backdropFilter =
      'blur(20px)';

  }

  else {

    navbar.style.background =
      'rgba(3, 10, 7, .62)';

  }

});

// AUTH PANEL SWITCH

const loginPanel =
  document.getElementById('loginPanel');

const registerPanel =
  document.getElementById('registerPanel');

const showRegister =
  document.getElementById('showRegister');

const showLogin =
  document.getElementById('showLogin');

const showLoginText =
  document.getElementById('showLoginText');


// SHOW REGISTER

if(showRegister){

  showRegister.addEventListener('click', (e) => {

    e.preventDefault();

    loginPanel.style.display = 'none';

    registerPanel.style.display = 'grid';

  });

}


// SHOW LOGIN

if(showLogin){

  showLogin.addEventListener('click', (e) => {

    e.preventDefault();

    registerPanel.style.display = 'none';

    loginPanel.style.display = 'grid';

  });

}


if(showLoginText){

  showLoginText.addEventListener('click', (e) => {

    e.preventDefault();

    registerPanel.style.display = 'none';

    loginPanel.style.display = 'grid';

  });

}


// FAVORITE HEART

const favoriteButtons =
  document.querySelectorAll('.favorite-heart');

favoriteButtons.forEach((button) => {

  button.addEventListener('click', () => {

    button.classList.toggle('active');

  });

});


// RATING STAR

const ratingGroups =
  document.querySelectorAll('.rating-stars');

ratingGroups.forEach((group) => {

  const ratingButtons =
    group.querySelectorAll('button');

  const ratingInput =
    document.getElementById('ratingValue');

  ratingButtons.forEach((button, index) => {

    button.addEventListener('click', () => {

      const ratingValue = index + 1;

      ratingButtons.forEach((btn, btnIndex) => {

        btn.classList.toggle(
          'active',
          btnIndex < ratingValue
        );

      });

      if(ratingInput){

        ratingInput.value = ratingValue;

      }

    });

  });

});


// SEARCH BUTTON

const searchButton =
  document.querySelector('.btn-search');
const searchDestinationInput =
  document.querySelector('.search-destination input');
const destGrid = document.querySelector('.dest-grid');
const destCards = document.querySelectorAll('.dest-card');

function parseDateString(value) {
  if (!value) return null;
  const map = {
    Jan: 0, Feb: 1, Mar: 2, Apr: 3, Mei: 4,
    Jun: 5, Jul: 6, Agu: 7, Sep: 8,
    Okt: 9, Nov: 10, Des: 11
  };
  const parts = value.split(' ');
  if (parts.length < 3) return null;
  const day = parseInt(parts[0], 10);
  const month = map[parts[1]] !== undefined ? map[parts[1]] : 0;
  const year = parseInt(parts[2], 10);
  return new Date(year, month, day);
}

function parseDestDates(card) {
  const dateText = card.querySelector('.dest-date')?.textContent.trim();
  if (!dateText) return { start: null, end: null };
  const parts = dateText.split(' - ').map(part => part.trim());
  const year = parts[1]?.split(' ').pop();
  const startText = `${parts[0]} ${year}`;
  return {
    start: parseDateString(startText),
    end: parseDateString(parts[1])
  };
}

function updateDestEmptyMessage(show) {
  if (!destGrid) return;
  let empty = destGrid.querySelector('.dest-empty');
  if (show) {
    if (!empty) {
      empty = document.createElement('div');
      empty.className = 'dest-empty';
      empty.textContent = 'Tidak ada destinasi sesuai filter.';
      destGrid.appendChild(empty);
    }
  } else {
    if (empty) empty.remove();
  }
}

function filterDestinations() {
  const query = searchDestinationInput?.value.trim().toLowerCase() || '';
  const selectedDate = searchDateInput?.value ? new Date(searchDateInput.value) : null;
  let visible = 0;

  destCards.forEach((card) => {
    const name = card.querySelector('.dest-name')?.textContent.toLowerCase() || '';
    const loc = card.querySelector('.dest-loc')?.textContent.toLowerCase() || '';
    const hasQuery = !query || name.includes(query) || loc.includes(query);
    let hasDate = true;

    if (selectedDate) {
      const { start, end } = parseDestDates(card);
      hasDate = start && end && selectedDate >= start && selectedDate <= end;
    }

    if (hasQuery && hasDate) {
      card.style.display = '';
      visible += 1;
    } else {
      card.style.display = 'none';
    }
  });

  updateDestEmptyMessage(visible === 0);
}

if (searchButton) {
  searchButton.addEventListener('click', () => {
    filterDestinations();
  });
}

if (searchDestinationInput) {
  searchDestinationInput.addEventListener('input', filterDestinations);
}

if (typeof searchDateInput !== 'undefined' && searchDateInput) {
  searchDateInput.addEventListener('change', filterDestinations);
}

// SMOOTH FADE IN

const cards = document.querySelectorAll(
  '.dest-card, .favorite-card, .trip-history-card'
);

const observer = new IntersectionObserver((entries) => {

  entries.forEach((entry) => {

    if(entry.isIntersecting){

      entry.target.style.opacity = '1';

      entry.target.style.transform =
        'translateY(0)';

    }

  });

}, {
  threshold: 0.1
});

cards.forEach((card) => {

  card.style.opacity = '0';

  card.style.transform =
    'translateY(30px)';

  card.style.transition =
    'all .7s ease';

  observer.observe(card);

});

const profilePhotoInput = document.getElementById('profilePhotoInput');
const profilePhotoName = document.querySelector('.file-upload-filename');

if(profilePhotoInput && profilePhotoName){
  profilePhotoInput.addEventListener('change', (event) => {
    const file = event.target.files[0];
    profilePhotoName.textContent = file ? file.name : 'Tidak ada file dipilih';
  });
}

const searchDateField = document.getElementById('searchDateField');
const searchDateInput = document.getElementById('searchDateInput');
const searchDateValue = searchDateField ? searchDateField.querySelector('.field-value') : null;
const searchParticipantField = document.getElementById('searchParticipantField');
const participantPanel = document.getElementById('participantPanel');
const participantAdultCount = document.getElementById('participantAdultCount');
const participantChildCount = document.getElementById('participantChildCount');
const searchParticipantValue = document.getElementById('searchParticipantValue');

function formatDateLabel(value) {
  if (!value) return 'Pilih Tanggal';
  const date = new Date(value);
  const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
  return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
}

function updateParticipantLabel() {
  const adults = parseInt(participantAdultCount.textContent, 10);
  const children = parseInt(participantChildCount.textContent, 10);
  let label = `${adults} Dewasa`;
  if (children > 0) {
    label += `, ${children} Anak`;
  }
  searchParticipantValue.textContent = label;
}

if (searchDateField && searchDateInput && searchDateValue) {
  searchDateField.addEventListener('click', () => {
    if (typeof searchDateInput.showPicker === 'function') {
      searchDateInput.showPicker();
    } else {
      searchDateInput.click();
    }
  });

  searchDateInput.addEventListener('change', (event) => {
    searchDateValue.textContent = formatDateLabel(event.target.value);
  });
}

if (searchParticipantField && participantPanel) {
  searchParticipantField.addEventListener('click', (event) => {
    event.stopPropagation();
    participantPanel.style.display = participantPanel.style.display === 'block' ? 'none' : 'block';
  });

  document.addEventListener('click', (event) => {
    if (!participantPanel.contains(event.target) && !searchParticipantField.contains(event.target)) {
      participantPanel.style.display = 'none';
    }
  });

  participantPanel.addEventListener('click', (event) => {
    event.stopPropagation();
    const button = event.target.closest('.participant-btn');
    if (!button) return;

    const type = button.dataset.type;
    const action = button.dataset.action;
    const target = type === 'adult' ? participantAdultCount : participantChildCount;
    let value = parseInt(target.textContent, 10);

    if (action === 'increase') {
      value += 1;
    } else if (action === 'decrease') {
      value = Math.max(type === 'adult' ? 1 : 0, value - 1);
    }

    target.textContent = value;
    updateParticipantLabel();
  });
}

