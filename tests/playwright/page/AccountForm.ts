import { expect, Locator, Page } from "@playwright/test";
import Select2 from "@hipanel-core/input/Select2";
import Alert from "@hipanel-core/ui/Alert";
import Account from "@hipanel-module-hosting/model/Account";
import Input from "@hipanel-core/input/Input";

export default class AccountForm {
  private page: Page;

  constructor(page: Page) {
    this.page = page;
  }

  async fill(account: Account) {
    await Select2.field(this.page, `#account-0-client`).setValue(account.client);
    await Select2.field(this.page, `#account-0-server`).setValue(account.server);
    await Input.field(this.page, '#account-0-login').fill(account.login);
    await this.setRandomPassword();
  }

  async save() {
    await this.page.locator("text=Save").click();
  }

  async seeSuccessAccountCreatingAlert() {
    await Alert.on(this.page).hasText("Account creating task has been added to queue");
  }

  private async setRandomPassword() {
    await this.page.locator("text=Random").click();
    await this.page.locator("text=Medium").click();
  }
}
