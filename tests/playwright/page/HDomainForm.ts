import { expect, Locator, Page } from "@playwright/test";
import Select2 from "@hipanel-core/input/Select2";
import Alert from "@hipanel-core/ui/Alert";
import Input from "@hipanel-core/input/Input";
import HDomain from "@hipanel-module-hosting/model/HDomain";

export default class HDomainForm {
  private page: Page;

  constructor(page: Page) {
    this.page = page;
  }

  async fill(domain: HDomain) {
    await Select2.field(this.page, `#hdomain-0-client`).setValue(domain.client);
    await Select2.field(this.page, `#hdomain-0-server`).setValue(domain.server);
    await Select2.field(this.page, '#hdomain-0-account').setValue(domain.account);
    await Input.field(this.page, '#hdomain-0-domain').fill(domain.domainName);
    await Select2.field(this.page, '#hdomain-0-ip').setValue(domain.ip);
  }

  async save() {
    await this.page.locator("text=Save").click();
  }

  async seeSuccessAccountCreatingAlert() {
    await Alert.on(this.page).hasText("Domain has been created successfully");
  }
}
