import { expect, Locator, Page } from "@playwright/test";
import Select2 from "@hipanel-core/input/Select2";
import { Alert } from "@hipanel-core/shared/ui/components";
import Input from "@hipanel-core/input/Input";
import IP from "@hipanel-module-hosting/model/IP";

export default class IPForm {
  private page: Page;

  constructor(page: Page) {
    this.page = page;
  }

  async fill(ip: IP) {
    await Input.field(this.page, '#ip-0-ip').fill(ip.ip);
    await Select2.field(this.page, `#link-0-0-device`).setValue(ip.linkDevice);
    await Select2.field(this.page, `#link-0-0-service_id`).clickFirstOnTheList();
  }

  async setTag(tag: string) {
    await Select2.field(this.page, `#ip-0-tags`).setValue(tag);
  }

  async save() {
    await this.page.locator("text=Save").click();
  }

  async seeSuccessIPCreatingAlert() {
    await Alert.on(this.page).hasText("IP address was created successfully");
  }
}
