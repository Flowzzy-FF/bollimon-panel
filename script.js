let storageKey = "bollimon_sube_data";
let db = {};
let seciliSube = "";

function girisYap() {
    const sifre = document.getElementById('giris-sifre').value;
    if(sifre === "1234") {
        seciliSube = document.getElementById('sube-secim').value;
        storageKey = "bollimon_" + seciliSube;
        db = JSON.parse(localStorage.getItem(storageKey)) || { as: 0, al: 0 };
        document.getElementById('login-screen').classList.add('hidden');
        document.getElementById('main-panel').classList.remove('hidden');
        document.getElementById('panel-sube-adi').innerText = seciliSube + " ŞUBESİ";
        document.getElementById('r-sube').innerText = seciliSube + " Şubesi Raporu";
        document.getElementById('r-tarih').innerText = new Date().toLocaleDateString('tr-TR');
        arayuzGuncelle();
    } else { alert("Hatalı şifre!"); }
}

function sevkiyatEkle() {
    db.as += (parseFloat(document.getElementById('s_as_k').value) || 0) * 8;
    db.al += (parseFloat(document.getElementById('s_al_k').value) || 0) * 8;
    localStorage.setItem(storageKey, JSON.stringify(db));
    document.getElementById('s_as_k').value = "";
    document.getElementById('s_al_k').value = "";
    arayuzGuncelle();
}

function arayuzGuncelle() {
    document.getElementById('cur_as').innerText = db.as;
    document.getElementById('cur_as_k').innerText = (db.as / 8).toFixed(1) + " Koli";
    document.getElementById('cur_al').innerText = db.al;
    document.getElementById('cur_al_k').innerText = (db.al / 8).toFixed(1) + " Koli";
    guncelle();
}

function guncelle() {
    const get = id => parseFloat(document.getElementById(id).value) || 0;
    let s_t_as = Math.max(0, get('t_ac_as') - get('t_ka_as'));
    let s_t_al = Math.max(0, get('t_ac_al') - get('t_ka_al'));
    let k_v_as = get('v_ka_as_koli') * 8;
    let k_v_al = get('v_ka_al_koli') * 8;
    let s_v_as = Math.max(0, db.as - k_v_as);
    let s_v_al = Math.max(0, db.al - k_v_al);

    document.getElementById('tablo-vucut').innerHTML = `
        <tr><td>Acısız T.</td><td style="text-align:center; color:#fbbf24;">${get('t_ac_as')}kg</td><td style="text-align:center;">${s_t_as}kg</td><td style="text-align:right; color:#94a3b8;">${get('t_ka_as')}kg</td></tr>
        <tr><td>Acılı T.</td><td style="text-align:center; color:#ef4444;">${get('t_ac_al')}kg</td><td style="text-align:center;">${s_t_al}kg</td><td style="text-align:right; color:#94a3b8;">${get('t_ka_al')}kg</td></tr>
        <tr><td>Acısız V.</td><td style="text-align:center; color:#fbbf24;">${s_v_as}Ad</td><td style="text-align:center;">${s_v_as}Ad</td><td style="text-align:right; color:#94a3b8;">0Ad</td></tr>
        <tr><td>Acılı V.</td><td style="text-align:center; color:#ef4444;">${s_v_al}Ad</td><td style="text-align:center;">${s_v_al}Ad</td><td style="text-align:right; color:#94a3b8;">0Ad</td></tr>
    `;
    document.getElementById('alt-as').innerText = get('v_ka_as_koli') + " Koli";
    document.getElementById('alt-al').innerText = get('v_ka_al_koli') + " Koli";
    window.temp_db = { as: k_v_as, al: k_v_al };
}

function fotoCek() {
    html2canvas(document.getElementById('capture-area'), { backgroundColor: '#0f172a', scale: 3 }).then(canvas => {
        const link = document.createElement('a');
        link.download = `Bollimon_${seciliSube}_${new Date().toLocaleDateString()}.png`;
        link.href = canvas.toDataURL();
        link.click();
    });
}

function gunuKapat() {
    if(confirm("Günü kapatıyorsunuz?")) {
        localStorage.setItem(storageKey, JSON.stringify(window.temp_db));
        location.reload();
    }
}
