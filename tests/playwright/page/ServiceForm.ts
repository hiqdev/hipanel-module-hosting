import { expect, Locator, Page } from "@playwright/test";
import Select2 from "@hipanel-core/input/Select2";
import Alert from "@hipanel-core/ui/Alert";
import Input from "@hipanel-core/input/Input";
import Service from "@hipanel-module-hosting/model/Service";
import Dropdown from "@hipanel-core/input/Dropdown";

export default class ServiceForm {
  private page: Page;

  constructor(page: Page) {
    this.page = page;
  }

  async fill(service: Service) {
    await Select2.field(this.page, `#service-0-client`).setValue(service.client);
    await Select2.field(this.page, `#service-0-server`).setValue(service.server);
    await Input.field(this.page, '#service-0-name').fill(service.name);
    await Input.field(this.page, '#service-0-bin').fill(service.bin);
    await Input.field(this.page, '#service-0-etc').fill(service.etc);
    await Dropdown.field(this.page, `#service-0-soft`).setValue(service.soft);
    await Dropdown.field(this.page, `#service-0-state`).setValue(service.status);
    await Select2.field(this.page, `#service-0-ips`).setValue(service.ip);
  }

  async save() {
    await this.page.locator("text=Save").click();
  }

  async seeSuccessServiceCreatingAlert() {
    await Alert.on(this.page).hasText("Service was created successfully");
  }
}
