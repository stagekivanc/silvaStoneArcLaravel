window.SILVA_CATS = window.SILVA_CATS || { all: 'Hepsi', wood: 'Wood Serisi', metal: 'Metal Serisi', signature: 'Kök Serisi', textile: 'Traverten Serisi' };
window.SILVA_COLORS = window.SILVA_COLORS || { all: 'Tümü', beyaz: 'Beyaz', krem: 'Krem', bej: 'Bej', gumus: 'Gümüş', bakir: 'Bakır', antrasit: 'Antrasit', siyah: 'Siyah' };
window.silvaTitle = (p) => String((p && (p.title || p.name)) || '').replace(/\s+Duvar Paneli$/i, '').replace(/\s+Wall Panel$/i, '');
window.silvaHref = window.silvaHref || ((p) => 'urun.html?code=' + encodeURIComponent(p.code));
window.silvaSpec = (p) => {
  const size = String(p.size || '').replace(/x/gi, ' × ');
  const thick = String(p.thick || '').replace('-', '–');
  if (size && thick) return `${size} × ${thick} mm`;
  if (size) return `${size} mm`;
  return '';
};
window.SILVA_HERO_SLIDES = window.SILVA_HERO_SLIDES || [
  {
    img: 'assets/products/mt012/04.jpg',
    kicker: 'Silva Arc Panel · Metal Serisi',
    title: 'Mimari yüzey',
    lead: 'Fırçalanmış metal dokulu paneller; resepsiyon, kolon ve feature wall’da keskin bir mimari karakter.',
    tone: 'dark',
  },
  {
    img: 'assets/products/tyd13/02.jpg',
    kicker: 'Silva Arc Panel · Kök Serisi',
    title: 'Kök dokusu',
    lead: 'Kök kaplama karakterli paneller; lobi ve konut iç mekânında sıcak, parlak bir duvar odağı.',
    tone: 'light',
  },
  {
    img: 'assets/products/sh-60/02.jpg',
    kicker: 'Silva Arc Panel · Wood Serisi',
    title: 'Salon odağı',
    lead: 'Doğal ceviz ve meşe yüzeyler. Oturma alanlarında sakin ahşap dokuyla net bir mimari merkez.',
    tone: 'light',
  },
];
window.SILVA_HOME_FEATURED = window.SILVA_HOME_FEATURED || ['MT012', 'MT011', 'TYD13', 'HY01217-1', 'SH-34', 'PM-48', 'SH-60', 'CT-05'];
window.silvaFold = (s) =>
  String(s || '')
    .toLocaleLowerCase('tr')
    .replace(/ı/g, 'i')
    .replace(/İ/g, 'i')
    .normalize('NFD')
    .replace(/[\u0300-\u036f]/g, '');
window.silvaMatch = (p, q) => {
  const needle = window.silvaFold(q).replace(/\s+/g, ' ').trim();
  if (!needle) return true;
  const hay = window.silvaFold(
    [p.code, p.name, window.silvaTitle(p), p.cat, window.SILVA_CATS[p.cat], window.SILVA_COLORS[p.color], p.color, p.material].join(' ')
  );
  const compact = hay.replace(/\s+/g, '');
  return needle.split(' ').every((part) => hay.includes(part) || compact.includes(part.replace(/\s/g, '')));
};
window.silvaDesc = (p) => {
  const cat = window.SILVA_CATS[p.cat] || '';
  const color = window.SILVA_COLORS[p.color] || '';
  const spec = window.silvaSpec(p);
  const title = window.silvaTitle(p);
  return `${title} (${p.code})${cat ? `, ${cat} koleksiyonuna ait` : ''} dekoratif duvar panelidir.${color ? ` ${color} ton.` : ''}${spec ? ` ${spec}.` : ''}${p.material ? ` ${p.material}.` : ''} Yalnızca iç mekâna uygundur.`;
};

window.SILVA_PRODUCTS = window.SILVA_PRODUCTS || [
  {
    code: 'PM-48',
    name: 'Açık Meşe Duvar Paneli',
    cat: 'wood',
    color: 'krem',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/pm-48/01.jpg',
    imgs: ['assets/products/pm-48/01.jpg'],
  },
  {
    code: 'SH-60',
    name: 'Doğal Meşe Duvar Paneli',
    cat: 'wood',
    color: 'bej',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/sh-60/01.jpg',
    imgs: [
      'assets/products/sh-60/01.jpg',
      'assets/products/sh-60/02.jpg',
      'assets/products/sh-60/03.jpg',
      'assets/products/sh-60/04.jpg',
    ],
  },
  {
    code: 'SH-57',
    name: 'Koyu Ceviz Duvar Paneli',
    cat: 'wood',
    color: 'bej',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/sh-57/01.jpg',
    imgs: ['assets/products/sh-57/01.jpg'],
  },
  {
    code: 'CT-04',
    name: 'Ceviz Duvar Paneli',
    cat: 'wood',
    color: 'bej',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/ct-04/01.jpg',
    imgs: ['assets/products/ct-04/01.jpg', 'assets/products/ct-04/02.png', 'assets/products/ct-04/03.png'],
  },
  {
    code: 'CT-05',
    name: 'Füme Meşe Duvar Paneli',
    cat: 'wood',
    color: 'siyah',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/ct-05/01.jpg',
    imgs: ['assets/products/ct-05/01.jpg', 'assets/products/ct-05/02.png', 'assets/products/ct-05/03.png'],
  },
  {
    code: 'CT-19',
    name: 'Antrasit Meşe Duvar Paneli',
    cat: 'wood',
    color: 'antrasit',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/ct-19/01.jpg',
    imgs: ['assets/products/ct-19/01.jpg'],
  },
  {
    code: 'SH-33',
    name: 'Bej Traverten Duvar Paneli',
    cat: 'textile',
    color: 'bej',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/sh-33/01.jpg',
    imgs: ['assets/products/sh-33/01.jpg'],
  },
  {
    code: 'SH-34',
    name: 'Fildişi Traverten Duvar Paneli',
    cat: 'textile',
    color: 'beyaz',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/sh-34/01.jpg',
    imgs: ['assets/products/sh-34/01.jpg'],
  },
  {
    code: 'SH-36',
    name: 'Terra Traverten Duvar Paneli',
    cat: 'textile',
    color: 'krem',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/sh-36/01.jpg',
    imgs: ['assets/products/sh-36/01.jpg'],
  },
  {
    code: 'HY1217-7',
    name: 'Kök Antrasit Duvar Paneli',
    cat: 'signature',
    color: 'antrasit',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/hy1217-7/01.jpg',
    imgs: ['assets/products/hy1217-7/01.jpg'],
  },
  {
    code: 'HY1217-2',
    name: 'Kök Gri Duvar Paneli',
    cat: 'signature',
    color: 'gumus',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/hy1217-2/01.jpg',
    imgs: ['assets/products/hy1217-2/01.jpg'],
  },
  {
    code: 'HY01217-3',
    name: 'Kök Vizon Duvar Paneli',
    cat: 'signature',
    color: 'krem',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/hy01217-3/01.jpg',
    imgs: ['assets/products/hy01217-3/01.jpg'],
  },
  {
    code: 'HY01217-1',
    name: 'Kök Ceviz Duvar Paneli',
    cat: 'signature',
    color: 'bej',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/hy01217-1/01.jpg',
    imgs: ['assets/products/hy01217-1/01.jpg'],
  },
  {
    code: 'TYD11',
    name: 'Natural Kök Duvar Paneli',
    cat: 'signature',
    color: 'krem',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/tyd11/01.jpg',
    imgs: ['assets/products/tyd11/01.jpg'],
  },
  {
    code: 'TYD13',
    name: 'Konyak Kök Duvar Paneli',
    cat: 'signature',
    color: 'bej',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/tyd13/01.jpg',
    imgs: [
      'assets/products/tyd13/01.jpg',
      'assets/products/tyd13/02.jpg',
      'assets/products/tyd13/03.jpg',
      'assets/products/tyd13/04.jpg',
      'assets/products/tyd13/05.jpg',
      'assets/products/tyd13/06.jpg',
    ],
  },
  {
    code: 'MT011',
    name: 'Şampanya Duvar Paneli',
    cat: 'metal',
    color: 'bej',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/mt011/01.jpg',
    imgs: [
      'assets/products/mt011/01.jpg',
      'assets/products/mt011/02.jpg',
      'assets/products/mt011/03.jpg',
      'assets/products/mt011/04.jpg',
    ],
  },
  {
    code: 'MT012',
    name: 'İnox Duvar Paneli',
    cat: 'metal',
    color: 'gumus',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/mt012/01.jpg',
    imgs: [
      'assets/products/mt012/01.jpg',
      'assets/products/mt012/02.jpg',
      'assets/products/mt012/03.jpg',
      'assets/products/mt012/04.jpg',
      'assets/products/mt012/05.jpg',
      'assets/products/mt012/06.jpg',
    ],
  },
  {
    code: 'MT013',
    name: 'Titanyum Duvar Paneli',
    cat: 'metal',
    color: 'gumus',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/mt013/01.jpg',
    imgs: ['assets/products/mt013/01.jpg', 'assets/products/mt013/02.jpg'],
  },
  {
    code: 'MT014',
    name: 'Antrasit Duvar Paneli',
    cat: 'metal',
    color: 'antrasit',
    size: '60x280',
    thick: '8',
    depot: 1,
    material: 'Ahşap-polimer kompozit (WPC)',
    sizeExtra: 'Talep üzerine',
    img: 'assets/products/mt014/01.jpg',
    imgs: ['assets/products/mt014/01.jpg'],
  },
];
