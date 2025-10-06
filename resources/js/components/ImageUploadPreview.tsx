import { cn } from "@/lib/utils"
import { useEffect, useState } from "react"

export function ImageUploadPreview({ source, className, ...restProps }: { source: File | string | null, className?: string } & React.ImgHTMLAttributes<HTMLImageElement>) {
  const [src, setSrc] = useState<string | null>(null)

  useEffect(() => {
    if (source instanceof File) {
      const objectUrl = URL.createObjectURL(source)
      setSrc(objectUrl)

      return () => {
        URL.revokeObjectURL(objectUrl)
      }
    } else {
      setSrc(source)
    }
  }, [source])

  if (!src) {
    return null
  }

  return (
    <img src={src} className={cn('mt-4 h-24 rounded-md', className)} {...restProps} />
  )
}
