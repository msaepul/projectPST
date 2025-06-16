@extends('layouts.main')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Scan Tiket Pesawat PDF</title>
<style>
  @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
  body {
    font-family: 'Roboto', sans-serif;
    background: linear-gradient(135deg, #4481eb 0%, #04befe 100%);
    color: #fff;
    min-height: 100vh;
    margin: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 2rem;
  }
  h1 {
    font-weight: 700;
    margin-bottom: 0.2rem;
  }
  p.subtitle {
    margin-top: 0;
    font-weight: 400;
    margin-bottom: 2rem;
    font-size: 1.1rem;
    text-shadow: 0 0 10px rgba(0,0,0,0.2);
  }
  .upload-section {
    background: rgba(255,255,255,0.15);
    border-radius: 12px;
    padding: 1.5rem 2rem;
    box-shadow: 0 8px 24px rgba(1, 121, 255, 0.3);
    max-width: 400px;
    width: 100%;
    text-align: center;
    margin-bottom: 2rem;
  }
  input[type="file"] {
    margin-top: 1rem;
    border-radius: 8px;
    padding: 0.5rem;
    border: none;
    width: 100%;
    cursor: pointer;
    font-size: 1rem;
  }
  input[type="file"]::-webkit-file-upload-button {
    border: none;
    background: #04befe;
    color: white;
    padding: 0.6rem 1rem;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
  }
  .info-card {
    background: rgba(255,255,255,0.1);
    border-radius: 16px;
    padding: 1.5rem 2rem;
    max-width: 600px;
    width: 100%;
    box-shadow: 0 8px 24px rgba(1, 121, 255, 0.4);
    display: none;
    flex-direction: column;
    line-height: 1.6;
  }
  .info-card h2 {
    margin-top: 0;
    border-bottom: 2px solid #04befe;
    padding-bottom: 0.4rem;
    margin-bottom: 1rem;
    font-weight: 700;
  }
  .info-row {
    display: flex;
    justify-content: space-between;
    padding: 0.3rem 0;
  }
  .info-label {
    font-weight: 700;
    color: #a0d6ff;
  }
  .error-message {
    background: #ff3860;
    color: white;
    max-width: 400px;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    margin-top: 1rem;
    display: none;
    font-weight: 700;
    text-align: center;
    box-shadow: 0 4px 12px rgba(255, 56, 96, 0.7);
  }
  footer {
    margin-top: auto;
    font-size: 0.9rem;
    opacity: 0.7;
  }
</style>
</head>
<body>
  <h1>Scan Tiket Pesawat PDF</h1>
  <p class="subtitle">Unggah file PDF tiket pesawat Anda untuk mengekstrak data penerbangan.</p>

  <div class="upload-section">
    <label for="pdf-file">Pilih file PDF tiket pesawat:</label>
    <input type="file" id="pdf-file" accept="application/pdf" />
  </div>

  <div class="error-message" id="error-message"></div>

  <div class="info-card" id="info-card">
    <h2>Informasi Tiket</h2>
    <div class="info-row">
      <span class="info-label">Nama Penumpang:</span>
      <span id="passenger-name">-</span>
    </div>
    <div class="info-row">
      <span class="info-label">Nomor Penerbangan:</span>
      <span id="flight-number">-</span>
    </div>
    <div class="info-row">
      <span class="info-label">Tanggal:</span>
      <span id="flight-date">-</span>
    </div>
    <div class="info-row">
      <span class="info-label">Waktu Keberangkatan:</span>
      <span id="departure-time">-</span>
    </div>
    <div class="info-row">
      <span class="info-label">Bandara Asal:</span>
      <span id="departure-airport">-</span>
    </div>
    <div class="info-row">
      <span class="info-label">Bandara Tujuan:</span>
      <span id="arrival-airport">-</span>
    </div>
  </div>
  
  <h1>Scan Tiket Kereta PDF</h1>
<p class="subtitle">Unggah file PDF tiket kereta Anda untuk mengekstrak data perjalanan.</p>

<div class="upload-section">
  <label for="train-pdf-file">Pilih file PDF tiket kereta:</label>
  <input type="file" id="train-pdf-file" accept="application/pdf" />
</div>

<div class="error-message" id="train-error-message"></div>

<div class="info-card" id="train-info-card">
  <h2>Informasi Tiket Kereta</h2>
  <div class="info-row">
    <span class="info-label">Nama Penumpang:</span>
    <span id="train-passenger-name">-</span>
  </div>
  <div class="info-row">
    <span class="info-label">Nomor & Nama Kereta:</span>
    <span id="train-number">-</span>
  </div>
  <div class="info-row">
    <span class="info-label">Tanggal Berangkat:</span>
    <span id="train-date">-</span>
  </div>
  <div class="info-row">
    <span class="info-label">Jam Keberangkatan:</span>
    <span id="train-departure">-</span>
  </div>
  <div class="info-row">
    <span class="info-label">Jam Tiba:</span>
    <span id="train-arrival">-</span>
  </div>
  <div class="info-row">
    <span class="info-label">Dari:</span>
    <span id="train-from">-</span>
  </div>
  <div class="info-row">
    <span class="info-label">Tujuan:</span>
    <span id="train-to">-</span>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.15.349/pdf.min.js"></script>
<script>
  const pdfInput = document.getElementById('pdf-file');
  const errorMessage = document.getElementById('error-message');
  const infoCard = document.getElementById('info-card');

  // Elements to fill
  const passengerNameEl = document.getElementById('passenger-name');
  const flightNumberEl = document.getElementById('flight-number');
  const flightDateEl = document.getElementById('flight-date');
  const departureTimeEl = document.getElementById('departure-time');
  const departureAirportEl = document.getElementById('departure-airport');
  const arrivalAirportEl = document.getElementById('arrival-airport');
  
  const trainPdfInput = document.getElementById('train-pdf-file');
const trainErrorMessage = document.getElementById('train-error-message');
const trainInfoCard = document.getElementById('train-info-card');

const trainPassengerNameEl = document.getElementById('train-passenger-name');
const trainNumberEl = document.getElementById('train-number');
const trainDateEl = document.getElementById('train-date');
const trainDepartureEl = document.getElementById('train-departure');
const trainArrivalEl = document.getElementById('train-arrival');
const trainFromEl = document.getElementById('train-from');
const trainToEl = document.getElementById('train-to');

  pdfInput.addEventListener('change', async () => {
    errorMessage.style.display = 'none';
    infoCard.style.display = 'none';
    clearInfo();

    const file = pdfInput.files[0];
    if (!file) return;
    if (file.type !== 'application/pdf') {
      showError('File harus berformat PDF.');
      return;
    }

    try {
      const arrayBuffer = await file.arrayBuffer();
      const pdf = await pdfjsLib.getDocument({data: arrayBuffer}).promise;
      let fullText = '';
      for(let i=1; i <= pdf.numPages; i++) {
        const page = await pdf.getPage(i);
        const content = await page.getTextContent();
        const texts = content.items.map(item => item.str);
        fullText += texts.join(' ') + ' ';
      }
      parseTicketText(fullText);
    } catch (e) {
      console.error(e);
      showError('Gagal membaca file PDF.');
    }
  });

  function showError(msg) {
    errorMessage.textContent = msg;
    errorMessage.style.display = 'block';
  }
  function clearInfo() {
    passengerNameEl.textContent = '-';
    flightNumberEl.textContent = '-';
    flightDateEl.textContent = '-';
    departureTimeEl.textContent = '-';
    departureAirportEl.textContent = '-';
    arrivalAirportEl.textContent = '-';
  }

function parseTicketText(text) {
  const t = text.toUpperCase().replace(/\s+/g, ' ');
  console.log("Text:", t); // <--- Tambahkan ini!

  let passengerName = extractPassengerName(t);
  let flightNumber = extractFlightNumber(t);
  let flightDate = extractFlightDate(t); // Pastikan regex cocok dengan hasil log ini
  let departureTime = extractDepartureTime(t);
  let departureAirport = extractDepartureAirport(t);
  let arrivalAirport = extractArrivalAirport(t);

    // Show results
    passengerNameEl.textContent = passengerName || '-';
    flightNumberEl.textContent = flightNumber || '-';
    flightDateEl.textContent = flightDate || '-';
    departureTimeEl.textContent = departureTime || '-';
    departureAirportEl.textContent = departureAirport || '-';
    arrivalAirportEl.textContent = arrivalAirport || '-';
    infoCard.style.display = 'flex';
  }

  function extractPassengerName(text) {
    const regexes = [
      /PASSENGER\s*NAME\s*:\s*([A-Z\s]+)/i,
      /NAME\s*:\s*([A-Z\s]+)/i,
      /PASSENGER\s*:\s*([A-Z\s]+)/i,
      /PAX\s*NAME\s*:\s*([A-Z\s]+)/i,
      /([A-Z]+)\/([A-Z\s]+)\s+(MR|MRS|MS|MSTR|MISS)\b/i,
      /\b(MR|MRS|MS|MSTR|MISS)\s+([A-Z\s]{3,})\b/i
    ];

    for (const regex of regexes) {
      const match = text.match(regex);
      if (match) {
        if (regex.toString().includes('\\/')) {
          const lastName = capitalizeWords(match[1]);
          const firstMiddle = capitalizeWords(match[2]);
          const title = capitalizeWords(match[3].toLowerCase());
          return `${title}. ${firstMiddle} ${lastName}`.trim();
        } else if (regex.toString().includes('(MR|MRS|MS|MSTR|MISS)\\s+')) {
          const title = capitalizeWords(match[1].toLowerCase());
          const name = capitalizeWords(match[2]);
          return `${title}. ${name}`;
        } else {
          const rawName = match[1].trim();
          return capitalizeWords(rawName);
        }
      }
    }
    return null;
  }

function extractFlightNumber(text) {
  const match = text.match(/\b([A-Z]{2})[-\s]?(\d{1,4})\b/);
  if (match) {
    return `${match[1]} ${match[2]}`; // normalisasi ke format spasi
  }
  return null;
}



function extractFlightDate(text) {
  // Format: 18/05/2025
  let match = text.match(/\b(\d{1,2})\/(\d{1,2})\/(\d{4})\b/);
  if (match) return `${match[1].padStart(2, '0')}/${match[2].padStart(2, '0')}/${match[3]}`;

  // Format: 18-05-2025
  match = text.match(/\b(\d{1,2})-(\d{1,2})-(\d{4})\b/);
  if (match) return `${match[1].padStart(2, '0')}-${match[2].padStart(2, '0')}-${match[3]}`;

  // Format: 18 MAY 2025
  match = text.match(/\b(\d{1,2})\s+(JAN|FEB|MAR|APR|MAY|JUN|JUL|AUG|SEP|OCT|NOV|DEC)\s+(\d{4})\b/i);
  if (match) return `${match[1].padStart(2, '0')} ${match[2].toUpperCase()} ${match[3]}`;

  // Format Indonesia uppercase: MING 18 MEI 2025 , 06:35
  match = text.match(/\b(?:MING|SEN|SEL|RAB|KAM|JUM|SAB|MINGGU|SENIN|SELASA|RABU|KAMIS|JUMAT|SABTU)\s+(\d{1,2})\s+([A-Z]+)\s+(\d{4})/);
  if (match) {
    const tanggal = match[1].padStart(2, '0');
    const bulanText = match[2].toLowerCase();
    const tahun = match[3];

    const bulanMap = {
      'januari': 'JAN', 'februari': 'FEB', 'maret': 'MAR', 'april': 'APR',
      'mei': 'MAY', 'juni': 'JUN', 'juli': 'JUL', 'agustus': 'AUG',
      'september': 'SEP', 'oktober': 'OCT', 'november': 'NOV', 'desember': 'DEC'
    };

    const bulan = bulanMap[bulanText];
    if (bulan) return `${tanggal} ${bulan} ${tahun}`;
  }

  return null;
}


  

  function extractDepartureTime(text) {
    let match = text.match(/\b(\d{2}):(\d{2})\b/);
    if(match) return `${match[1]}:${match[2]}`;
    match = text.match(/\b(\d{2})(\d{2})\b/);
    if(match) {
      let hours = parseInt(match[1], 10);
      let minutes = parseInt(match[2], 10);
      if(hours < 24 && minutes < 60) return `${match[1]}:${match[2]}`;
    }
    return null;
  }



  function extractDepartureAirport(text) {
    let airports = text.match(/\b(CGK|SUB|DPS|JKT|BDO|LOP|SOC|HLP|KNO|UPG|DJJ|PLM|BXB|PNK|BTJ|PKU|CGK|JOG|SOC|MLG|SRG|BPN|PNK|SUB|DPS|BDJ|DJJ|UPG|TNJ|KTE|BTG|MDN|PKU|KDI|LSW|MKQ|TSJ|TIM|RTG|LUW|MDC|TMC|AMQ|TMC|BJW|KOE|NAH|TRK|LUV|MJU|LBJ|LBW|NPO|ARD|TMC|MJU)\b/);
    if(airports) return airports[0];
    let match = text.match(/(?:DEP|FROM|ORIGIN)[:\s]*([A-Z]{3})/);
    if(match) return match[1];
    return null;
  }

  function extractArrivalAirport(text) {
    let airports = text.match(/\b(CGK|SUB|DPS|JKT|BDO|LOP|SOC|HLP|KNO|UPG|DJJ|PLM|BXB|PNK|BTJ|PKU|CGK|JOG|SOC|MLG|SRG|BPN|PNK|SUB|DPS|BDJ|DJJ|UPG|TNJ|KTE|BTG|MDN|PKU|KDI|LSW|MKQ|TSJ|TIM|RTG|LUW|MDC|TMC|AMQ|TMC|BJW|KOE|NAH|TRK|LUV|MJU|LBJ|LBW|NPO|ARD|TMC|MJU)\b/gi);
    if(airports && airports.length > 1) return airports[1];
    let match = text.match(/(?:ARR|TO|DESTINATION)[:\s]*([A-Z]{3})/);
    if(match) return match[1];
    return null;
  }

  function capitalizeWords(str) {
    return str.toLowerCase().replace(/\b[a-z]/g, c => c.toUpperCase());
  }
  
  //untuk kereta
  
  trainPdfInput.addEventListener('change', async () => {
  trainErrorMessage.style.display = 'none';
  trainInfoCard.style.display = 'none';
  clearTrainInfo();

  const file = trainPdfInput.files[0];
  if (!file || file.type !== 'application/pdf') {
    trainErrorMessage.textContent = 'File harus berformat PDF.';
    trainErrorMessage.style.display = 'block';
    return;
  }

  try {
    const arrayBuffer = await file.arrayBuffer();
    const pdf = await pdfjsLib.getDocument({ data: arrayBuffer }).promise;
    let text = '';
    for (let i = 1; i <= pdf.numPages; i++) {
      const page = await pdf.getPage(i);
      const content = await page.getTextContent();
      const strings = content.items.map(item => item.str);
      text += strings.join(' ') + ' ';
    }
    parseTrainTicketText(text);
  } catch (err) {
    trainErrorMessage.textContent = 'Gagal membaca file PDF.';
    trainErrorMessage.style.display = 'block';
    console.error(err);
  }
});

function clearTrainInfo() {
  trainPassengerNameEl.textContent = '-';
  trainNumberEl.textContent = '-';
  trainDateEl.textContent = '-';
  trainDepartureEl.textContent = '-';
  trainArrivalEl.textContent = '-';
  trainFromEl.textContent = '-';
  trainToEl.textContent = '-';
}

function parseTrainTicketText(text) {
  const t = text.toUpperCase();

// Gabungkan dua regex:
// 1. Untuk "NAMA CONFIRMED"
// 2. Untuk blok teks setelah "Name" dengan huruf kapital semua
// 1. Ambil nama-nama dengan CONFIRMED
const confirmedNames = [...t.matchAll(/(?:^|\n|\s)(?!ID NUMBER)([A-Z]+(?:\s+[A-Z]+){1,3})\s+CONFIRMED\b/g)].map(m => m[1].trim());

// 2. Ambil nama dari blok "Name ..." atau "Nama Penumpang", dan bersihkan kata "NUMBER"
const nameBlockMatch = t.match(/Name(?:\s+Penumpang)?:\s*((?:[A-Z]+(?: [A-Z]+){1,2}\s*[,|\n]?)+)/);
let blockNames = [];
if (nameBlockMatch) {
  blockNames = nameBlockMatch[1]
    .replace(/\bNUMBER\b/g, '') // Hapus kata NUMBER
    .split(/,|\n/)
    .map(name => name.trim())
    .filter(name => /^[A-Z ]+$/.test(name)); // Hanya huruf kapital
}

// Gabungkan dan hilangkan duplikat
const allNames = Array.from(new Set([...confirmedNames, ...blockNames]));

// Gabungkan ke dalam satu string hasil
const result = allNames.join(', ');
trainPassengerNameEl.textContent = allNames.length ? allNames.join(', ') : '-';

  // Nomor dan nama kereta
  const trainMatch = t.match(/TRAIN NO\.? & NAME:?\s*(\d+)\s*\/\s*([A-Z\s]+)/);
  if (trainMatch) trainNumberEl.textContent = `${trainMatch[1]} / ${trainMatch[2].trim()}`;

  // Tanggal dan jam keberangkatan
  const departMatch = t.match(/DEPARTURE TIME:?\s*(\d{2}\/\d{2}\/\d{4}) (\d{2}:\d{2}:\d{2})/);
  if (departMatch) {
    trainDateEl.textContent = departMatch[1];
    trainDepartureEl.textContent = departMatch[2];
  }

  // Waktu tiba
  const arriveMatch = t.match(/ARRIVAL TIME:?\s*(\d{2}\/\d{2}\/\d{4}) (\d{2}:\d{2}:\d{2})/);
  if (arriveMatch) trainArrivalEl.textContent = arriveMatch[2];

  // Dari mana dan ke mana
  const routeMatch = t.match(/FROM:\s*([A-Z]+)\(BD\)\s*TO\s*:\s*([A-Z]+)\(KD\)/);
  if (routeMatch) {
    trainFromEl.textContent = routeMatch[1];
    trainToEl.textContent = routeMatch[2];
  }

  trainInfoCard.style.display = 'flex';
}
  
  

</script>
</body>
</html>

@endsection