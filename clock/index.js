// console.log(import.meta.url);
export class SVGClock extends HTMLElement {
    static observedAttributes = ['datetime', 'with-milliseconds', 'autoupdate'];
    #shadow;
    #H;
    #s;
    #i;
    #t;

    constructor() {
        super();
        (this.#shadow = this.attachShadow({mode: 'closed'})).innerHTML = svg;
        this.#t = this.#shadow.querySelector('#text');
        this.#H = this.#shadow.querySelector('#H');
        this.#i = this.#shadow.querySelector('#i');
        this.#s = this.#shadow.querySelector('#s');
    }

    set dateTime(v) {
        if (v == null) {
            this.removeAttribute('datetime');
            return;
        }
        if (v instanceof window.Temporal.Instant || v instanceof window.Temporal.ZonedDateTime) {
            v = v.epochMilliseconds;
        }
        this.setAttribute('datetime', new Date(v).toISOString());
    }

    get dateTime() {
        const v = this.getAttribute('datetime');
        if (v == null) return null;
        return new Date(v);
    }

    set instant(v) {
        this.dateTime = v;
    }

    get instant() {
        return this.dateTime.toTemporalInstant();
    }

    attributeChangedCallback(name, _oldValue, newValue, _xmlns) {
        if (name === 'autoupdate' && newValue !== null) {
            this.#autoupdate();
        }
        this.updateTime();
    }

    #autoupdate() {
        this.dateTime = Date.now();
        this.updateTime();
        if (this.hasAttribute('autoupdate')) {
            if (this.hasAttribute('with-milliseconds')) {
                requestAnimationFrame(() => this.#autoupdate());
            } else {
                setTimeout(() => this.#autoupdate(), 1000);
            }
        }
    }

    updateTime() {
        const d = new Date(this.dateTime ?? NaN);
        d.toISOString();
        if (!this.hasAttribute('with-milliseconds')) d.setUTCMilliseconds(0);
        const $date = d, $i = $date.getMilliseconds();
        const $s = ($date.getSeconds() * 6) + (($i / 1000) * 6);
        const $h = (($date.getHours() % 12) * 30) + ($date.getMinutes() / 2);
        const $m = ($date.getMinutes() * 6) + ($s / 60);
        this.#H.setAttribute('transform', `rotate(${$h})`);
        this.#s.setAttribute('transform', `rotate(${$s})`);
        this.#i.setAttribute('transform', `rotate(${$m})`);
        this.#t.textContent = this.formatDate($date) + ' ' + $date.toString().slice(16, 24);
    }

    formatDate(date) {
        const pad = function (number, size = 2) {
            return (+number).toString().padStart(size, '0');
        }, $date = new Date(date);
        return `${pad($date.getFullYear(), 4)}-${pad($date.getMonth() + 1)}-${pad($date.getDate())}`;
    }
}

export const svg = await fetch('clock.svg').then(resp =>
    resp.ok ? resp.text() : resp.text().then(throwValue));

function throwValue(value) {
    throw value;
}

customElements.define('favicond-svgclock', SVGClock);
