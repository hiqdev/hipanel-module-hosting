import { expect, Locator, Page } from "@playwright/test";
import Select2 from "@hipanel-core/input/Select2";
import Alert from "@hipanel-core/ui/Alert";
import Input from "@hipanel-core/input/Input";
import Mail from "@hipanel-module-hosting/model/Mail";

export default class MailForm {
  private page: Page;

  constructor(page: Page) {
    this.page = page;
  }

  async fill(mail: Mail) {
    await Select2.field(this.page, `#mail-0-client`).setValue(mail.client);
    await Select2.field(this.page, `#mail-0-server`).setValue(mail.server);
    await Select2.field(this.page, `#mail-0-account`).setValue(mail.account);
    await Input.field(this.page, '#mail-0-nick').fill(mail.email);
    await Select2.field(this.page, `#mail-0-hdomain_id`).setValue(mail.domain);
    await Input.field(this.page, '#mail-0-password').fill(mail.password);
  }

  async save() {
    await this.page.locator("text=Save").click();
  }

  async seeSuccessMailCreatingAlert() {
    await Alert.on(this.page).hasText("Mailbox creating task has been added to queue");
  }
}
