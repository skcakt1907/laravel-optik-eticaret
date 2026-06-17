import { test, expect } from '@playwright/test';

const ADMIN = { email: 'admin@ornek-optik.com', password: 'admin123' };

async function loginAs(page, email, password) {
    await page.goto('/giris');
    await page.fill('input[name="email"]', email);
    await page.fill('input[name="password"]', password);
    await page.click('button[type="submit"]');
    await page.waitForLoadState('networkidle');
}

test.describe('Admin paneli', () => {
    test('admin giriş yapıp panele ulaşır', async ({ page }) => {
        await loginAs(page, ADMIN.email, ADMIN.password);
        await expect(page).toHaveURL(/yonetim/);
        await expect(page.locator('.brand')).toContainText('Optik');
    });

    test('tüm admin sayfaları yükleniyor', async ({ page }) => {
        await loginAs(page, ADMIN.email, ADMIN.password);

        for (const path of [
            '/yonetim',
            '/yonetim/products',
            '/yonetim/categories',
            '/yonetim/orders',
            '/yonetim/appointments',
            '/yonetim/messages',
            '/yonetim/settings',
        ]) {
            const resp = await page.goto(path);
            expect(resp.status(), `${path} status`).toBe(200);
            await expect(page.locator('h1')).toBeVisible();
        }
    });

    test('ürün ekleme formu açılıyor', async ({ page }) => {
        await loginAs(page, ADMIN.email, ADMIN.password);
        await page.goto('/yonetim/products/create');
        await expect(page.locator('input[name="name"]')).toBeVisible();
        await expect(page.locator('input[name="price"]')).toBeVisible();
    });
});

test.describe('Admin profili', () => {
    test('profil sayfası açılıyor (ad/e-posta/şifre alanları)', async ({ page }) => {
        await loginAs(page, ADMIN.email, ADMIN.password);
        await page.goto('/yonetim/profile');
        await expect(page.locator('input[name="name"]')).toBeVisible();
        await expect(page.locator('input[name="email"]')).toBeVisible();
        await expect(page.locator('input[name="current_password"]')).toBeVisible();
        await expect(page.locator('input[name="password"]')).toBeVisible();
    });

    test('telefon güncelleme çalışıyor', async ({ page }) => {
        await loginAs(page, ADMIN.email, ADMIN.password);
        await page.goto('/yonetim/profile');
        await page.fill('input[name="phone"]', '0252 999 88 77');
        await page.click('button[type="submit"]');
        await expect(page.locator('.alert-a')).toContainText('güncellendi');
    });

    test('yanlış mevcut şifreyle değiştirme reddediliyor', async ({ page }) => {
        await loginAs(page, ADMIN.email, ADMIN.password);
        await page.goto('/yonetim/profile');
        await page.fill('input[name="current_password"]', 'yanlissifre');
        await page.fill('input[name="password"]', 'yenisifre123');
        await page.fill('input[name="password_confirmation"]', 'yenisifre123');
        await page.click('button[type="submit"]');
        await expect(page.locator('.alert-a.err')).toContainText('Mevcut şifreniz hatalı');
    });
});

test.describe('Kategori ikon seçici', () => {
    test('ikon dropdown var ve optik ikonları içeriyor', async ({ page }) => {
        await loginAs(page, ADMIN.email, ADMIN.password);
        await page.goto('/yonetim/categories/create');
        const sel = page.locator('select#iconSel');
        await expect(sel).toBeVisible();
        const count = await sel.locator('option').count();
        expect(count).toBeGreaterThanOrEqual(15);
        // birkaç optik ikonu mevcut mu
        for (const v of ['bi-eyeglasses', 'bi-sun', 'bi-circle', 'bi-droplet']) {
            await expect(sel.locator(`option[value="${v}"]`)).toHaveCount(1);
        }
    });

    test('seçilen ikon önizlemeye yansıyor', async ({ page }) => {
        await loginAs(page, ADMIN.email, ADMIN.password);
        await page.goto('/yonetim/categories/create');
        await page.selectOption('select#iconSel', 'bi-binoculars');
        await expect(page.locator('#iconPrev i')).toHaveClass(/bi-binoculars/);
    });

    test('ikon seçilerek kategori kaydedilebiliyor', async ({ page }) => {
        await loginAs(page, ADMIN.email, ADMIN.password);
        await page.goto('/yonetim/categories/create');
        await page.fill('input[name="name"]', 'PW İkon Test');
        await page.selectOption('select#iconSel', 'bi-gem');
        await page.click('form.form-a button[type="submit"]');
        await expect(page).toHaveURL(/categories/);
        await expect(page.locator('body')).toContainText('PW İkon Test');
    });
});

test.describe('Güvenlik — yetki kontrolü', () => {
    test('giriş yapmamış kullanıcı /yonetim göremez (girişe yönlenir)', async ({ page }) => {
        await page.goto('/yonetim');
        await expect(page).toHaveURL(/giris/);
    });

    test('admin olmayan rastgele /yonetim isteği korunuyor', async ({ request }) => {
        // Oturumsuz doğrudan istek: 302 (girişe) bekleniyor, 200 OLMAMALI
        const resp = await request.get('/yonetim', { maxRedirects: 0 });
        expect([301, 302]).toContain(resp.status());
    });

    test('hassas yollar robots.txt ile engellenmiş', async ({ request }) => {
        const resp = await request.get('/robots.txt');
        const body = await resp.text();
        expect(body).toContain('Disallow: /yonetim');
    });
});
