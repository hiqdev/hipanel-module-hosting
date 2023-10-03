import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import ServiceHelper from "@hipanel-module-hosting/helper/ServiceHelper";
import Service from "@hipanel-module-hosting/model/Service";
import ServiceForm from "@hipanel-module-hosting/page/ServiceForm";

function getRandomArbitrary(min, max) {
  min = Math.ceil(min);
  max = Math.floor(max);
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

const randomInt = getRandomArbitrary(101, 999);

const service: Service = {
  client: "hipanel_test_reseller",
  server: "DSTEST02",
  name: "apache" + randomInt,
  ip: "DSTEST02: 127.0.0.199",
  bin: "/bin",
  etc: "/etc/apache" + randomInt,
  soft: "login",
  status: "started",
};

test.describe("It tests create/view/update Service", () => {

  test("Create service @hipanel-module-hosting @admin", async ({ adminPage }) => {
    const serviceHelper = new ServiceHelper(adminPage);
    const serviceForm = new ServiceForm(adminPage);

    await serviceHelper.gotoIndexService();
    await serviceHelper.gotoCreateService();

    await serviceForm.fill(service);
    await serviceForm.save();

    await serviceForm.seeSuccessServiceCreatingAlert();
  });

  test("Correct view service @hipanel-module-hosting @admin", async ({ adminPage }) => {
    const serviceHelper = new ServiceHelper(adminPage);
    await serviceHelper.gotoIndexService();
    await serviceHelper.gotoServicePage(service.server);
    await serviceHelper.checkDetailViewData(service);
  });

  test("Update service @hipanel-module-hosting @admin", async ({ adminPage }) => {
    const serviceHelper = new ServiceHelper(adminPage);

    await serviceHelper.gotoIndexService();
    await serviceHelper.gotoUpdatePage(service.name);

    await serviceHelper.updateData(service);
    await serviceHelper.save();

    await serviceHelper.seeSuccessAlert("Service was updated successfully");
  });

});
