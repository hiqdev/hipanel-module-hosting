import { expect } from "@playwright/test";
import { test } from "@hipanel-core/fixtures";
import AccountHelper from "@hipanel-module-hosting/helper/AccountHelper";

test("Copy accounts form validates input @hipanel-module-hosting @admin", async ({ adminPage }) => {
  const accountHelper = new AccountHelper(adminPage);
  adminPage.on("dialog", dialog => dialog.accept());

  await accountHelper.gotoIndexAccount();
  await adminPage.locator("#dropdownMenu1").click();
  await adminPage.locator("text=Copy accounts").click();
  await expect(adminPage).toHaveTitle("Copy accounts");

  const form = adminPage.locator("#account-copy-form");
  await form.locator("button[type=submit]").click();
  await expect(form.locator(".field-accountcopyform-old_server .help-block")).toHaveText("Old server cannot be blank.");
  await expect(form.locator(".field-accountcopyform-new_server .help-block")).toHaveText("New server cannot be blank.");
  await expect(form.locator(".field-accountcopyform-new_client .help-block")).toHaveText("New client cannot be blank.");

  await form.locator("#accountcopyform-move_mails").check();
  await expect(form.locator(".field-accountcopyform-move_mails .help-block")).toHaveText("");

  await form.locator("#accountcopyform-copy_domains").uncheck();
  await form.locator("#accountcopyform-move_mails").uncheck();
  await form.locator("#accountcopyform-move_mails").check();
  await expect(form.locator(".field-accountcopyform-move_mails .help-block")).toHaveText("Mails can be moved only together with domains");
});
