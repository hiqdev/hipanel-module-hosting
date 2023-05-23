import { test } from "@hipanel-core/fixtures";
import { expect } from "@playwright/test";
import ServiceHelper from "@hipanel-module-hosting/helper/ServiceHelper";
import Service from "@hipanel-module-hosting/model/Service";
import ServiceForm from "@hipanel-module-hosting/page/ServiceForm";

const service: Service = {
  client: 'hipanel_test_reseller',
  server: 'DSTEST02',
  name: 'apache22',
  ip: 'DSTEST02: 127.0.0.199',
  bin: '/bin',
  etc: '/etc/apache2',
  soft: 'login',
  status: 'started',
};

test("Create service @hipanel-module-hosting @admin", async ({ adminPage }) => {

  const serviceHelper = new ServiceHelper(adminPage);
  const serviceForm = new ServiceForm(adminPage);

  await serviceHelper.gotoIndexService();
  await serviceHelper.gotoCreateService();

  await serviceForm.fill(service);
  await serviceForm.save();

  await serviceForm.seeSuccessServiceCreatingAlert();
});
