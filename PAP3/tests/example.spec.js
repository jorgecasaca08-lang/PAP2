// @ts-check
const { test, expect } = require('@playwright/test');

test('homepage has expected title and handles privacy modal', async ({ page }) => {
  await page.goto('http://localhost:8000');

  // Expect a title "to contain" a substring.
  await expect(page).toHaveTitle(/Alfa Engenharia & Construções/);

  // Handle privacy modal
  const privacyModal = await page.locator('#politicaModal');
  if (await privacyModal.isVisible()) {
    await page.click('#accept-privacy');
  }

  // Verify modal is hidden
  await expect(privacyModal).toBeHidden();

  await page.screenshot({ path: '/app/verification/index.png' });
});

test('about page has expected title and handles privacy modal', async ({ page }) => {
    await page.goto('http://localhost:8000/about.php');

    // Expect a title "to contain" a substring.
    await expect(page).toHaveTitle(/Sobre Nós/);

    // Handle privacy modal
  const privacyModal = await page.locator('#politicaModal');
  if (await privacyModal.isVisible()) {
    await page.click('#accept-privacy');
  }

  // Verify modal is hidden
  await expect(privacyModal).toBeHidden();

    await page.screenshot({ path: '/app/verification/about.png' });
});

test('services page has expected title and handles privacy modal', async ({ page }) => {
    await page.goto('http://localhost:8000/services.php');

    // Expect a title "to contain" a substring.
    await expect(page).toHaveTitle(/Serviços/);

    // Handle privacy modal
  const privacyModal = await page.locator('#politicaModal');
  if (await privacyModal.isVisible()) {
    await page.click('#accept-privacy');
  }

  // Verify modal is hidden
  await expect(privacyModal).toBeHidden();

    await page.screenshot({ path: '/app/verification/services.png' });
});

test('portfolio page has expected title and handles privacy modal', async ({ page }) => {
    await page.goto('http://localhost:8000/portfolio.php');

    // Expect a title "to contain" a substring.
    await expect(page).toHaveTitle(/Portefólio/);

    // Handle privacy modal
  const privacyModal = await page.locator('#politicaModal');
  if (await privacyModal.isVisible()) {
    await page.click('#accept-privacy');
  }

  // Verify modal is hidden
  await expect(privacyModal).toBeHidden();

    await page.screenshot({ path: '/app/verification/portfolio.png' });
});

test('contact page has expected title and handles privacy modal', async ({ page }) => {
    await page.goto('http://localhost:8000/contact.php');

    // Expect a title "to contain" a substring.
    await expect(page).toHaveTitle(/Contactos/);

    // Handle privacy modal
  const privacyModal = await page.locator('#politicaModal');
  if (await privacyModal.isVisible()) {
    await page.click('#accept-privacy');
  }

  // Verify modal is hidden
  await expect(privacyModal).toBeHidden();

    await page.screenshot({ path: '/app/verification/contact.png' });
});

test('terms page has expected title and handles privacy modal', async ({ page }) => {
    await page.goto('http://localhost:8000/terms.php');

    // Expect a title "to contain" a substring.
    await expect(page).toHaveTitle(/Termos e Condições/);

    // Handle privacy modal
  const privacyModal = await page.locator('#politicaModal');
  if (await privacyModal.isVisible()) {
    await page.click('#accept-privacy');
  }

  // Verify modal is hidden
  await expect(privacyModal).toBeHidden();

    await page.screenshot({ path: '/app/verification/terms.png' });
});

test('login page has expected title and handles privacy modal', async ({ page }) => {
    await page.goto('http://localhost:8000/login.php');

    // Expect a title "to contain" a substring.
    await expect(page).toHaveTitle(/Login/);

    // Handle privacy modal
  const privacyModal = await page.locator('#politicaModal');
  if (await privacyModal.isVisible()) {
    await page.click('#accept-privacy');
  }

  // Verify modal is hidden
  await expect(privacyModal).toBeHidden();

    await page.screenshot({ path: '/app/verification/login.png' });
});
