import React from "react";
import { Toaster } from "@/components/ui/sonner";
import { usePage } from "@inertiajs/react";
import { SharedData } from "@/types";
import { toast } from "sonner";

export function PageWrapper({ children }: { children: React.ReactNode }) {
  const { flash, errors } = usePage<SharedData>().props

  if (flash.success) toast.success(flash.success)
  if (flash.warning) toast.success(flash.warning)
  if (flash.info) toast.success(flash.info)
  if (errors) {
    Object.values(errors).forEach((error) => {
      toast.error(error)
    })
  }

  return (
    <>
      <div className="min-h-dvh bg-gradient-to-b from-cyan-200 to-white to-[60vh] text-gray-900">
        {children}
      </div>
      <Toaster position="top-center" richColors closeButton />
    </>
  )
}
